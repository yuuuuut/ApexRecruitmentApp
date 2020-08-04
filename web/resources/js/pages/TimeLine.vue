<template>
  <div>
    <Post 
      v-for="user in users"
      :key="user.post.id"
      :item="user.post"
    />
    <infinite-loading
      spinner="waveDots"
      @infinite="infiniteHandler"
    >
      <v-btn
        class="ma-2" 
        outlined color="indigo"
        slot="no-more"
        @click="scrollTop"
      >
        Topへ戻る
      </v-btn>
    </infinite-loading>
  </div>
</template>

<script>
import Post from '../components/Post.vue'

export default {
  components: {
    Post
  },
  data () {
    return {
      users: [],
      page: 1,
    }
  },
  methods: {
    async infiniteHandler ($state) {
      await axios.get('/api/timeline', {
        params: {
          page: this.page,
          per_page: 1,
        },
      }).then(({ data }) => {
        console.log(data)
        setTimeout(() => {
          if (data.data.length) {
            this.page += 1
            this.users.push(...data.data)
            $state.loaded()
          } else {
            $state.complete()
          }
        }, 700)
      }).catch ((err) => {
        $state.complete()
      })
    },
    scrollTop () {
      window.scrollTo({
        top: 0,
        behavior: "instant"
      })
    }
  },
}
</script>