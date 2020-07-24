<template>
  <div>
    <h1>PostIndex</h1>
    <Post 
      v-for="post in posts"
      :key="post.id"
      :item="post"
    />
    <PostForm />
  </div>
</template>

<script>
import PostForm from '../components/forms/PostForm.vue'
import Post from '../components/Post.vue'

export default {
  components: {
    PostForm,
    Post
  },
  data () {
    return {
      posts: [],
    }
  },
  methods: {
    async getPosts () {
      const response = await axios.get('/api/posts')
      console.log(response)

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.posts = response.data.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.getPosts()
      },
      immediate: true
    }
  }
}
</script>