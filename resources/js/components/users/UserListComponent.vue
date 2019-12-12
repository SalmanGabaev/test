<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="title m-0">{{ 'navigation.users' | trans }}</p>
                <a href="users/create" class="action btn btn-primary text-white py-0 px-4">{{ 'components.create_button' | trans }}</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at }}</td>
                    <td class="w-25 text-right">
                        <a :href="`/users/${user.id}/edit`" class="btn btn-sm btn-secondary px-3">{{ 'components.edit_button' | trans }}</a>
                        <button type="button" class="btn btn-sm btn-danger px-3" @click="destroy(user.id)">{{ 'components.delete_button' | trans }}</button>
                    </td>
                </tr>
            </table>
            <pagination :data="users" @pagination-change-page="getUsers"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UsersListComponent",

        data() {
            return {
                users: {},
            }
        },

        created() {
            this.loadUsers();
        },

        methods: {
            /**
             * users data load method
             */
            loadUsers() {
                axios.get(`/api/users`).then( ({data}) => (this.users = data) )
            },

            /**
             * User delete method
             * @param id
             */
            destroy(id) {
                axios.delete(`/api/users/${id}`).then((data) => {
                    if (data.status === 204) {
                        let index = this.users.data.findIndex(user => user.id === id);
                        this.users.data.splice(index, 1)
                    }
                })
            },

            /**
             * get users from next page
             * @param page
             */
            getUsers(page = 1) {
                axios.get('/api/users?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            }

        }
    }
</script>

<style scoped>

</style>
