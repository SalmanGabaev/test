<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="title m-0">{{ 'navigation.users' | trans }}</p>
            </div>
        </div>

        <div class="card-body">

            <div class="alert alert-success" role="alert" v-if="success">
                {{ success }}
            </div>

            <form v-on:submit.prevent="update">
                <div class="form-row py-2">
                    <label for="validationName">{{ 'form-label.name' | trans }}</label>
                    <input type="text" v-model.trim="userData.name" class="form-control" :class="{'is-invalid': errors && errors.name}" id="validationName" required>

                    <div class="invalid-feedback" v-if="errors && errors.name">
                        {{ errors.name[0] }}
                    </div>
                </div>

                <div class="form-row py-2">
                    <label for="validationEmail">{{ 'form-label.email' | trans }}</label>
                    <input type="email" id="validationEmail" class="form-control" v-model.trim="userData.email" :class="{'is-invalid': errors && errors.email}" required>

                    <div class="invalid-feedback" v-if="errors && errors.email">
                        {{ errors.email[0] }}
                    </div>
                </div>

                <div class="form-row py-2">
                    <label for="validationPassword">{{ 'form-label.password' | trans }}</label>
                    <input type="text" id="validationPassword" class="form-control" v-model.trim="userData.password" :class="{'is-invalid': errors && errors.password}" required>

                    <div class="invalid-feedback" v-if="errors && errors.password">
                        {{ errors.password[0] }}
                    </div>
                </div>

                <div class="form-row py-2">
                    <button class="btn btn-primary">{{ 'components.update_button' | trans }}</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserEditComponent",
        props: ['user'],
        data() {
            return {
                userData: {
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password,
                },

                errors: null,
                success: null,
            }
        },

        updated() {
            if (this.success !== null) setTimeout(() => {this.clearMessages()}, 4000)
        },

        methods: {
            /**
             * user update method
             */
            update() {
                this.errors = null;

                axios.put(`/api/users/${this.user.id}`, this.userData).then(response => {
                    this.success = response.data;
                }).catch(error => {
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors;
                })
            },

            /**
             * messages cleaning method
             */
            clearMessages() {
                this.errors = null;
                this.success = null;
            }
        }
    }
</script>

<style scoped>

</style>
