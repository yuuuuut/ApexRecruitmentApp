<template>
  <div>
    <v-select
      @change="changePlatform()"
      :items="['PS4', 'PC']"
      v-model="platform"
      class="mt-4 ml-15 mr-15"
    ></v-select>
    <div>
      <Post 
        v-for="post in posts"
        :key="post.id"
        :item="post"
      />
    </div>
    <infinite-loading
      spinner="waveDots"
      :identifier="infinited"
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
    <div v-if="isLogin">
      <div class="position-fixed-right">
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
      platform: 'PS4',
      posts: [],
      page: 1,
      infinited: 1,
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
          platform: this.platform,
          page: this.page,
          per_page: 1,
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
    },
    changePlatform () {
      this.page = 1;
      this.posts = [];
      this.infinited += 1;
    }
  }
}
</script>

<style scoped>
.position-fixed-right {
  position: fixed;
  bottom: 20px;
  right: 10px;
}
</style>