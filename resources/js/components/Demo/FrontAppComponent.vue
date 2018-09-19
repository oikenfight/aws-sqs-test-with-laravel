<template>
    <div class="row">
        <div class="col-12" style="padding-top: 40px;">
            <div class="card card-default">
                <div class="card-header">Front API Server (Create Message by SNS)</div>

                <div class="card-body">
                    <div class="form">
                        <!-- message -->
                        <div class="form-group row">
                            <label class="col-form-label col-2 text-right" for="formPhoneNumber">Phone Number</label>
                            <input class="form-control col-9" v-model="form.phone_number" id="formPhoneNumber">
                        </div>

                        <!-- message -->
                        <div class="form-group row">
                            <label class="col-form-label col-2 text-right" for="formMessage">Message</label>
                            <input class="form-control col-9" v-model="form.message" id="formMessage">
                        </div>

                        <!-- submit -->
                        <div class="form-group row" style="padding-top: 20px;">
                            <button type="button" class="offset-2 btn btn-primary" :class="{disabled: isDisabled}" @click="send">EnQueue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                form: {
                    phone_number: '',
                    message: ''
                },
            }
        },
        computed: {
            isDisabled () {
                return this.form.phone_number === '' || this.form.message === ''
            },
        },
        methods: {
            send () {
                // axios.post('/api/sqs_test/send', this.form)
                axios.post('/api/demo/front/send', this.form).then(response => {
                    console.log('send: ' + this.form.message + ', response: ')
                    console.log(response)
                    this.form.phone_number = ''
                    this.form.message = ''
                })
            },
        }
    }
</script>

<style scoped>

</style>
