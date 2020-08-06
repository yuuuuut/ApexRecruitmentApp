<template>
  <div v-if="dataReady">
    <Todo :user="user" />
    <v-card
      class="mx-auto mt-4"
      width="730px"
    >
      <v-list-item three-line>
        <v-list-item-content>
          <div class="d-flex flex-row-reverse">
            <div v-if="currentUser.id !== user.id">
              <FollowForm 
                :user="user"
                @addFollower="addFollowerM"
                @removeFollower="removeFollowerM"
              />
            </div>
          </div>
          <div class="d-flex justify-space-between">
            <div class="d-flex justify-start">
              <div class="text-h5">{{ user.name }}</div>
              <div v-show="isFollowed">
                <v-chip class="mt-1 ml-2" color="cyan" text-color="white" small>フォローされています</v-chip>
              </div>
            </div>
            <div v-if="currentUser.id === user.id">
              <ProfileForm
                :user="user"
                @reloadUser="getUser"
              />
            </div>
          </div>
          <div v-show="user.profile" class="mt-2 mb-3">
            <div class="blue-grey--text text--lighten-1" v-if="user.profile.content">{{ user.profile.content }}</div>
          </div>
          <FollowCount
            :followCount="followCount"
            :followerCount="followerCount"
            :followings="followings"
            :followers="followers"
          />
        </v-list-item-content>
      </v-list-item>
    </v-card>
    <div v-if="post">
      <Post
        :item="post"
      />
    </div>
  </div>
  <div v-else>
    <v-skeleton-loader
      class="mx-auto mt-8"
      width="720px"
      type="card"
    ></v-skeleton-loader>
  </div>
</template>

<script>
import Post from '../components/Post.vue'
import ProfileForm from '../components/forms/ProfileForm.vue'
import FollowForm  from '../components/forms/FollowForm.vue'
import FollowCount from '../components/FollowCount.vue'
import Todo from '../components/Todo.vue'

export default {
  props: {
    id: {
      type: String,
      required: true,
    }
  },
  components: {
    Post,
    ProfileForm,
    FollowForm,
    FollowCount,
    Todo,
  },
  data () {
    return {
      user: null,
      post: null,
      followings: [],
      followers: [],
      followCount: 0,
      followerCount: 0,
      isFollowed: false,
      dataReady: false,
    }
  },
  computed: {
    currentUser () {
      return this.$store.getters['auth/currentUser']
    }
  },
  methods: {
    async getUser () {
      this.dataReady = false

      const response = await axios.get(`/api/users/${this.id}`)

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.user = response.data[0]
      this.post = response.data[0].post
      this.isFollowed = response.data[0].is_followed

      this.followings = response.data[1].reverse()
      this.followCount = this.followings.length

      this.followers = response.data[2].reverse()
      this.followerCount = this.followers.length

      this.dataReady = true
    },
    addFollowerM () {
      this.followerCount += 1
      this.followers.unshift(this.currentUser)
    },
    removeFollowerM () {
      this.followerCount -= 1
      this.followers = this.followers.filter( function (el, index, array) {
        return el.id !== this.id
      }, this.currentUser)
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.getUser()
      },
      immediate: true
    }
  }
}
</script>