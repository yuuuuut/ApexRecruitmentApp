<template>
  <div>
    <div v-if="dataReady">
      <Post 
        :item="post"
      />
    </div>
    <div v-else>
      <v-skeleton-loader
        class="mx-auto mt-8"
        width="650px"
        type="card"
      ></v-skeleton-loader>
    </div>
  </div>
</template>

<script>
import Post from '../components/Post.vue'

export default {
  components: {
    Post
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      post: null,
      dataReady: false,
    }
  },
  methods: {
    async getPost () {
      const response = await axios.get(`/api/posts/${this.id}`)

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post = response.data
      this.dataReady = true
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.getPost()
      },
      immediate: true
    },
  },
}
</script>