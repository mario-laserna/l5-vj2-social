<template>
    <li>
        <a href="/notifications">
            Unread notifications
            <span class="badge">{{ all_nots_count }}</span>
        </a>
    </li>
</template>

<script>
    export default {
        mounted() {
            axios.get('/get_unread')
                .then( (nots) => {
                    console.log(nots);
                    nots.data.forEach( (not) => {
                        this.$store.commit('add_not', not);
                    });
                });
        },
        computed: {
            all_nots_count: function() {
                return this.$store.getters.all_nots_count;
            }
        }
    }
</script>