/*
 |--------------------------------------------------------------------------
 | Imports
 |--------------------------------------------------------------------------
 */
import axios from 'axios'
import debounce from 'lodash/debounce'
import Vue from 'vue'

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

new Vue({
    el: '#app',

    data: {
        parameters: 'phone:',
        phone: '',
        country: '',
        country_name: '',
        withCountry: false,
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
        countryInputName() {
            if (this.country_name.length > 0 && this.country_name !== 'phone') {
                return this.country_name
            }

            return 'field_country'
        },

        requestData() {
            const data = {
                parameters: this.parameters,
                field: this.phone,
            }

            if (this.withCountry) {
                data[this.countryInputName] = this.country
                data.country_name = this.countryInputName
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
        }
    },
    methods: {
        toggle() {
            this.withCountry = ! this.withCountry
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

            axios.post('api/validate', this.requestData)
                .then(response => {
                    this.loading = false;
                    this.response = response.data;
                    if (response.data.message.length != 0) {
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