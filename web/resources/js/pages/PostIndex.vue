<template>
  <div>
    <Post 
      v-for="post in posts"
      :item="post"
    />
    <infinite-loading 
      spinner="waveDots"
      @infinite="infiniteHandler">
      <v-btn
        class="ma-2" 
        outlined color="indigo"
        slot="no-more"
        @click="scrollTop">
        Topへ戻る
      </v-btn>
    </infinite-loading>
    <div v-if="isLogin">
      <div class="position--fixed">
        <PostForm />
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

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
      page: 1,
    }
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    async infiniteHandler ($state) {
      await axios.get('/api/posts', {
        params: {
          page: this.page,
          per_page: 1
        },
      }).then(({ data }) => {
        console.log(data)
        setTimeout(() => {
          if (data.data.length) {
            this.page += 1
            this.posts.push(...data.data)
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

<style scoped>
.position--fixed {
  position: fixed;
  bottom: 20px;
  right: 10px;
}
</style>