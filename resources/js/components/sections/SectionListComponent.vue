<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="title m-0">{{ 'navigation.sections' | trans }}</p>
                <a href="sections/create" class="action btn btn-primary text-white py-0 px-4">{{ 'components.create_button' | trans }}</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tr v-for="section in sections.data" :key="section.id">
                    <td>
                        <img class="logo img-thumbnail" :src="`/storage/logo/${section.logo}`" :alt="section.name">
                    </td>
                    <td>
                        <p class="mb-1"><strong>{{ section.name }}</strong></p>
                        <p class="mb-0">{{ section.description }}</p>
                    </td>
                    <td>
                        <p class="mb-0"><strong>Users</strong></p>
                        <ul class="m-0 user-list">
                            <li v-for="(user, index) in section.users" :key="index">{{ user.name }}</li>
                        </ul>
                    </td>
                    <td class="w-25 text-right">
                        <a :href="`sections/${section.id}/edit`" class="btn btn-sm btn-secondary px-3">{{ 'components.edit_button' | trans }}</a>
                        <button type="button" class="btn btn-sm btn-danger px-3" @click="destroy(section.id)">{{ 'components.delete_button' | trans }}</button>
                    </td>
                </tr>
            </table>
            <pagination :data="sections" @pagination-change-page="getSections"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SectionListComponent",

        data() {
            return {
                sections: {},
            }
        },

        created() {
            this.loadSections()
        },

        methods: {
            /**
             * sections data load method
             */
            loadSections() {
                axios.get(`/api/sections`).then( ({data}) => (this.sections = data) )
            },

            /**
             * Section delete method
             * @param id
             */
            destroy(id) {
                axios.delete(`/api/sections/${id}`).then((data) => {
                    if (data.status === 204) {
                        let index = this.sections.findIndex(section => section.id === id);
                        this.sections.splice(index, 1)
                    }
                })
            },

            /**
             * get sections from next page
             * @param page
             */
            getSections(page = 1) {
                axios.get('/api/sections?page=' + page).then(({data}) => this.sections = data);
            }
        }
    }
</script>

<style scoped>
    .logo {
        width: 80px;
        height: 60px;
        max-width: 100px;
    }
    .user-list {
        list-style-type: decimal;
    }
</style>
