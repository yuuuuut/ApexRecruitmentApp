<template>
  <div>
    <Post 
      v-for="post in posts"
      :key="post.id"
      :item="post"
    />
    <div class="position--fixed">
      <PostForm />
    </div>
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

<style scoped>
.position--fixed {
  position: fixed;
  bottom: 30px;
  right: 35px;
}
</style>