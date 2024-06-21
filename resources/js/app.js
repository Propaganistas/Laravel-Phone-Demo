/*
 |--------------------------------------------------------------------------
 | Imports
 |--------------------------------------------------------------------------
 */
import axios from 'axios'
import { debounce } from 'lodash'
import Vue from 'vue'
import UIkit from 'uikit'
import UIkitIcons from 'uikit/dist/js/uikit-icons'

window.UIkit = window.UIKit = UIkit
UIkit.use(UIkitIcons)

/*
 |--------------------------------------------------------------------------
 | Configuration
 |--------------------------------------------------------------------------
 */

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
    'X-Requested-With': 'XMLHttpRequest',
}

axios.defaults.withCredentials = true

/*
 |--------------------------------------------------------------------------
 | Application
 |--------------------------------------------------------------------------
 */

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search.toString())

    new Vue({
        el: '#app',

        data: {
            parameters: params.get('parameters') || 'phone:',
            phone: params.get('phone') || '',
            country: params.get('country') || '',
            country_name: params.get('country_name') || '',
            withCountry: !! params.get('with_country') || false,
            loading: false,
            response: {
                loading: false,
                request: {},
                rules: {},
                passes: null,
                message: '',
            },
        },


        computed: {
            requestData() {
                const data = {
                    parameters: this.parameters,
                    phone: this.phone,
                }

                if (this.withCountry) {
                    data.with_country = 1
                    data.country = this.country
                    data.country_name = this.country_name
                }

                return data
            },

            shouldValidate() {
                return this.phone.trim().length > 0 ||
                    (this.parameters.trim().length > 0 && this.parameters !== 'phone:')
            },

            showHelp() {
                return ! this.shouldValidate
            }
        },
        watch: {
            phone(value, old) {
                if (this.shouldValidate) {
                    this.validate()
                }
            },

            parameters(value, old) {
                if (this.shouldValidate) {
                    this.validate()
                }
            },

            country(value, old) {
                if (this.shouldValidate) {
                    this.validate()
                }
            },

            country_name(value, old) {
                if (this.shouldValidate) {
                    this.validate()
                }
            },

            withCountry(value, old) {
                if (this.shouldValidate) {
                    this.validate()
                }

                if (! value) {
                    this.country = ''
                    this.country_name = ''
                }
            }
        },

        mounted() {
            if (this.shouldValidate) {
                this.validate()
            }
        },

        methods: {
            toggle() {
                this.withCountry = this.withCountry === 1 ? 0 : 1
            },

            formatAsPHPArray(json) {
                if (typeof json === 'undefined') {
                    return ''
                }

                return JSON.stringify(json, null, 4)
                    .replace(/^{/g,"[")
                    .replace(/}$/g,"]")
                    .replace(/": /g,"' => ")
                    .replace(/"/g, "'")
            },

            validate: debounce(function () {
                this.loading = true

                const url = new URL(window.location);
                url.search = (new URLSearchParams(this.requestData)).toString()
                window.history.replaceState({}, '', url)

                axios.post('api/validate', this.requestData)
                    .then(response => {
                        this.loading = false;
                        this.response = response.data;
                        if (response.data.message.length !== 0) {
                            this.response.message = JSON.stringify(response.data.message, null, 4)
                        }
                    })
                    .catch(error => {
                        this.loading = false;
                        this.response = error.response.data;
                    })
            }, 300)
        }
    });
})