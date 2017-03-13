<template>
    <div>
        <p class="text-center" v-if="loading">
            Loading....
        </p>
        <p class="text-center" v-if="!loading">
            <button class="btn btn-success" v-if="!status" @click="add_friend">Add Friend</button>
            <button class="btn btn-primary" v-if="status == 'pending'"  @click="accept_friend">Accept Friend</button>
            <span class="label label-primary" v-if="status == 'waiting'">Waiting for response</span>
            <span class="label label-success" v-if="status == 'friends'">Friends</span>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/check_relationship_status/' + this.profile_user_id)
                .then((resp) => {
                    console.log(resp)
                    this.status = resp.data.status;
                    this.loading = false;
                })
        },
        props:[
            'profile_user_id'
        ],
        data() {
            return {
                status: '',
                loading: true
            }
        },
        methods : {
            add_friend() {
                this.loading = true;

                axios.get('/add_friend/' + this.profile_user_id)
                    .then((r) => {
                        console.log(r);
                        if(r.data) {
                            this.status = 'waiting';
                            noty({
                               type: 'success',
                                layout: 'bottomLeft',
                                text: 'Friend request sent'
                            });
                            this.loading = false;
                        }
                    });
            },

            accept_friend() {
                this.loading = true;

                axios.get('/accept_friend/' + this.profile_user_id)
                    .then((r) => {
                        console.log(r);
                        if(r.data) {
                            this.status = 'friends';
                            noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'You are now friends.'
                            });
                            this.loading = false;
                        }
                    });
            }
        }
    }
</script>
