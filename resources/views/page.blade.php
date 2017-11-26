@extends('html')

@section('content')

    <div id="app">

        <div class="row" v-for="(phone, index) in inputs">

            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-8 col-sm-10 col-md-6">
                            <div class="form-group">
                                <label for="phone">Number</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Phone number" v-model="phone.number">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-2">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Code" v-model="phone.number_country">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="parameters">Validator parameters</label>
                                <input type="text" class="form-control" id="parameters" placeholder="Parameters" v-model="phone.parameters">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Results</label>
                                <pre class="pre-scrollable">@{{ phone.response.heading }}

@{{ phone.response.message }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>

        const App = new Vue({
            el: '#app',
            data: {
                inputs: [
                    @for($i = 0; $i < request('count', 1); $i++)
                    {
                        number: null,
                        number_country: null,
                        parameters: null,
                        response: {
                            heading: null,
                            message: null,
                        },
                    },
                    @endfor
                ]
            },
            watch: {
                @for($i = 0; $i < request('count', 1); $i++)
                    'inputs.{{ $i }}.number': {
                        handler: _.debounce(function () {
                            this.validate({{$i}});
                        }, 200),
                        deep: true
                    },
                    'inputs.{{ $i }}.number_country': {
                        handler: _.debounce(function () {
                            this.validate({{$i}});
                        }, 200),
                        deep: true
                    },
                    'inputs.{{ $i }}.parameters': {
                        handler: _.debounce(function () {
                            this.validate({{$i}});
                        }, 200),
                        deep: true
                    },
                @endfor
            },
            methods: {
                validate(index) {
                    axios.post('api/validate', this.inputs[index])
                        .then(response => {
                            this.inputs[index]['response']['heading'] = response.data.validation;
                            this.inputs[index]['response']['message'] = response.data.errors;
                        })
                        .catch(error => {
                            this.inputs[index]['response']['heading'] = error.response.data.exception;
                            this.inputs[index]['response']['message'] = error.response.data.message;
                        });
                }
            }
        });

    </script>

@endsection