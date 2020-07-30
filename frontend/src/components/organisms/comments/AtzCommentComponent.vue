<script>    
import Comments from './CommentComponent.vue';

export default {
    extends: Comments,
    methods: {
        async refreshComments() {
            return true;
        }
    },
}
</script>

<style>

</style>