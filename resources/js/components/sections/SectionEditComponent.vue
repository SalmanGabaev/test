<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="title m-0">{{ 'navigation.sections' | trans }}</p>
            </div>
        </div>

        <div class="card-body">

            <div class="alert alert-success" role="alert" v-if="success">
                {{ success }}
            </div>

            <form v-on:submit.prevent="update">
                <div class="form-row py-2">
                    <label for="validationName">{{ 'form-label.name' | trans }}</label>
                    <input type="text" v-model.trim="name" class="form-control" :class="{'is-invalid': errors && errors.name}" id="validationName" required>

                    <div class="invalid-feedback" v-if="errors && errors.name">
                        {{ errors.name[0] }}
                    </div>
                </div>

                <div class="form-row py-2">
                    <label for="validationDescription">{{ 'form-label.description' | trans }}</label>

                    <textarea class="form-control" id="validationDescription" v-model="description" :class="{'is-invalid': errors && errors.description}" required></textarea>

                    <div class="invalid-feedback" v-if="errors && errors.description">
                        {{ errors.description[0] }}
                    </div>
                </div>

                <div class="form-row py-2 mb-3">
                    <label for="validationDescription">{{ 'form-label.logo' | trans }}</label>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" :class="{'is-invalid': errors && errors.logo}" @change="onImageChange">
                        <label class="custom-file-label" for="validatedCustomFile" ref="fileName">{{ logo }}</label>
                        <div class="invalid-feedback" v-if="errors && errors.logo">{{ errors.logo[0] }}</div>
                    </div>

                    <div class="mt-2" v-if="sectionData.logo">
                        <img class="logo img-thumbnail" :src="`/storage/logo/${sectionData.logo}`" :alt="name">
                    </div>
                </div>

                <div class="form-row d-block py-2">
                    <p class="h4">{{ 'navigation.users' | trans }}</p>

                    <div class="form-check" v-for="user in usersData" :key="user.id">
                        <input class="form-check-input" type="checkbox" :id="`user-${user.id}`" :value="user.id" v-model="users">
                        <label class="form-check-label" :for="`user-${user.id}`">
                            {{ user.name }}
                        </label>
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
        name: "SectionEditComponent",
        props: ['sectionData', 'usersData', 'sectionUsers'],

        data() {
            return {
                name: this.sectionData.name,
                description: this.sectionData.description,
                logo: this.sectionData.logo,
                users: this.sectionUsers,
                errors: null,
                success: null,
            }
        },

        updated() {
            if (this.success !== null) setTimeout(() => {this.clearMessages()}, 4000);
        },

        methods: {
            /**
             * Section update method
             */
            update() {
                /**
                 * Remove errors
                 */
                this.errors = null;

                /**
                 * Create new FormData object
                 */
                let formData = new FormData;

                /**
                 * Set FormData configuration
                 */
                const config = {
                    headers: { 'Content-Type': 'application/json' }
                };

                /**
                 * Fill the FormData object with data
                 */
                formData.append("_method", "PUT");
                formData.append('name', this.name);
                formData.append('description', this.description);
                formData.append('logo', this.logo);
                formData.append('users', JSON.stringify(this.users));

                /**
                 * Send form data to server
                 */
                axios.post(`/api/sections/${this.sectionData.id}`, formData, config)
                    .then(response => {
                        this.success = response.data;
                    })
                    .catch(error => {
                        if (error.response.status === 422)
                            this.errors = error.response.data.errors;
                    });
            },

            /**
             * Selection image event processing method
             * @param e
             */
            onImageChange(e) {
                this.logo = e.target.files[0];
                this.$refs.fileName.textContent = e.target.files[0].name;
            },

            /**
             * messages cleaning method
             */
            clearMessages() {
                this.errors = null;
                this.success = null;
            },
        }
    }
</script>

<style scoped>
    .logo {
        max-width: 200px;
        max-height: 120px;
    }
</style>
