@extends('html')

@section('content')

    <div id="app" uk-grid>

        <div class="uk-flex-last@m uk-width-2-3@m" v-if="showHelp">
            <h3>Demo application</h3>
            <p>
            	This demo application allows you to test the phone validation component of the <a href="https://github.com/propaganistas/laravel-phone">Laravel-Phone</a> package.
            </p>
            <p class="uk-text-bold">Usage guidelines:</p>
            <ol uk-margin>
                <li>
                    The phone number's field will automatically get validated using the <code>phone</code> validator.
                    Provide some additional parameters to the validator as you wish.
                    This represents your server-side code.
                </li>
                <li>Enter the phone number you would like to test.</li>
                <li>
                    Optionally enable the presence of a country field and assign it some value.
                    By default it is named aptly so the validator will detect it automatically, but you can override its input name to omit this behavior.
                    In this case remember to specify the field's name as a validator parameter in order to be recognized during validation.
                </li>
            </ol>
            <p>
            	This is a safe playground. Nothing will be stored.
            </p>
        </div>

        <div class="uk-flex-last uk-width-2-3@m" v-else>

            <div class="uk-flex uk-flex-center" v-if="loading">
                <div uk-spinner class="uk-margin-small-top uk-margin-small-bottom"></div>
            </div>

            <div class="uk-margin uk-child-width-1-2@m" uk-grid v-if="! loading">
                <div>
                    <div class="uk-text-center">Input</div>
                    <div>
<pre>
@{{ formatAsPHPArray(response.request) }}
</pre>
                    </div>
                </div>

                <div>
                    <div class="uk-text-center">Validation rules</div>
                    <div>
<pre>
@{{ formatAsPHPArray(response.rules) }}
</pre>
                    </div>
                </div>
            </div>

            <div class="uk-margin" uk-margin v-if="! loading">
                <div class="uk-text-center">Result</div>

                <div uk-alert class="uk-alert uk-alert-success" v-if="response.passes">
                    <i uk-icon="icon: check" class="uk-margin-small-right"></i>
                    <span>Validation passes</span>
                </div>

                <div uk-alert class="uk-alert uk-alert-danger" v-if="! response.passes">
                    <i uk-icon="icon: close" class="uk-margin-small-right"></i>
                    <span v-if="response.exception">@{{ response.exception }}</span>
                    <span v-else>Validation failed</span>
                </div>

                <div v-if="response.message">
<pre>
@{{ response.message }}
</pre>
                </div>
            </div>

        </div>

        <div class="uk-flex-first@m uk-width-1-3@m">

            <div class="uk-margin uk-padding-small uk-background-muted" uk-margin>
                <div class="uk-text-center">Server-side</div>

                <div>
                    <label class="uk-form-label" for="parameters">
                        <span>Validator parameters</span>
                        <a href="https://github.com/propaganistas/laravel-phone#validation" class="uk-link-reset" target="_blank">
                            <i style="margin-left: 5px;" uk-icon="icon: info; ratio: 0.75;" uk-tooltip="pos: right;" title="Click to open the README"></i>
                        </a>
                    </label>
                    <div class="uk-form-controls uk-inline uk-width-1-1">
                        <input id="parameters" type="text" name="parameters" v-model="parameters" class="uk-input" placeholder="">
                    </div>
                </div>
            </div>

            <div class="uk-margin uk-padding-small uk-background-muted" uk-margin>
                <div class="uk-text-center">Frontend form</div>

                <div>
                    <label class="uk-form-label" for="phone">Phone number</label>
                    <div class="uk-form-controls">
                        <input id="phone" type="tel" name="phone" class="uk-input" v-model="phone" placeholder="">
                    </div>
                </div>

                <div>
                    <label class="uk-form-label" for="phone_country">
                        <span>Country field</span>
                        <span class="toggleable">(optional)</span>
                    </label>
                    <button class="uk-button uk-button-default uk-width-1-1 toggleable" type="button" uk-toggle="target: .toggleable" @click="toggle()">
                        Click to add
                    </button>
                    <div class="uk-form-controls toggleable" hidden>
                        <input id="phone_country" type="text" name="phone_country" class="uk-input" v-model="country" placeholder="Two-letter country code">
                    </div>
                </div>

                <div class="toggleable" hidden>
                    <label class="uk-form-label" for="phone_country">
                        <span>Country input name</span>
                        <i style="margin-left: 5px;" uk-icon="icon: info; ratio: 0.75;" uk-tooltip="pos: right;" title="Optionally rename the country field so it doesn't get autodetected by the validator"></i>
                    </label>
                    <div class="uk-form-controls">
                        <input id="_country_field_name" type="text" name="_country_field_name" v-model="country_name" class="uk-input uk-form-small" placeholder="field_country">
                    </div>
                </div>

                <div class="toggleable" hidden>
                    <button class="uk-button uk-button-default uk-width-1-1 toggleable" type="button" uk-toggle="target: .toggleable" hidden @click="toggle()">
                        Click to remove
                    </button>
                </div>
            </div>

        </div>


    </div>

@endsection
