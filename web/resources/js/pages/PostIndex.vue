<template>
  <div>
    {{ total }}
    <v-select
      @change="changePlatform()"
      v-if="!loading"
      :items="['PS4', 'PC']"
      v-model="platform"
      class="mt-4 ml-15 mr-15"
    ></v-select>
    <v-select
      v-if="loading"
      class="mt-4 ml-15 mr-15"
      disabled
    ></v-select>

    <v-dialog v-model="dialog" scrollable max-width="300px">
      <template v-slot:activator="{ on, attrs }">
        <div class="center-btn">
          <v-btn 
            outlined
            color="indigo"
            v-bind="attrs"
            v-on="on"
          >
            レジェンドで絞り込み
          </v-btn>
        </div>
      </template>
      <v-card>
        <v-card-text style="height: 300px;">
          <div v-for="(v, i) in legends" :key="i">
            <v-checkbox
              v-model="legend"
              :label="v"
              :value="v"
            ></v-checkbox>
          </div>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn
            color="blue darken-1" text
            @click="changePlatform(); dialog = false;"
          >
            絞り込み
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    {{ legend }}

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
      legend: [],
      legends: ['ブラッドハウンド', 'ジブラルタル', 'ライフライン', 'パスファインダー', 'レイス', 
                'バンガロール', 'ミラージュ', 'コースティック', 'ワットソン', 'クリプト',
                'レヴナント', 'ローバ', 'ランパート'],
      dialog: false,
      loading: false,
      posts: [],
      total: 0,
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
      this.loading= true
      await axios.get('/api/posts', {
        params: {
          platform: this.platform,
          legend: this.legend,
          page: this.page,
          per_page: 1,
        },
      }).then(({ data }) => {
        setTimeout(() => {
          console.log(data)
          this.total = data.total
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
      this.loading = false
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
.center-btn {
  text-align:center;
}

.position-fixed-right {
  position: fixed;
  bottom: 20px;
  right: 10px;
}
</style>