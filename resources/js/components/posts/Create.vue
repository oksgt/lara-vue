<template>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Tambah Post</div>
                    <div class="card-body">
                        <form @submit.prevent="PostStore">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" v-model="post.title" placeholder="Masukan Title">
                                <div v-if="validation.title">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.title[0] }}
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" rows="10" v-model="post.content" placeholder="Masukan Content"></textarea>
                                <div v-if="validation.content">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.content[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                                <button type="reset" class="btn btn-sm btn-default">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            post : {}, validation: []
        }
    },
    methods: {
        PostStore(){
            let uri = 'http://localhost:8000/api/posts/store';
            this.axios.post(uri, this.post)
                .then((response) => {
                    this.$router.push({
                        name: 'posts'
                    });
                }).catch(error => {
                    this.validation = error.response.data.data;
                });
        }
    }
}
</script>