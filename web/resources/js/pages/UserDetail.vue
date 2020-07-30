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
              <div v-if="isFollowed">
                <v-chip class="mt-1 ml-2" color="cyan" text-color="white" small>フォローされています</v-chip>
              </div>
            </div>
            <div v-if="currentUser.id === user.id">
              <ProfileForm
                @reloadUser="userShow"
              />
            </div>
          </div>

          <div v-if="user.profile" class="mt-2 mb-3">
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
    ProfileForm,
    FollowForm,
    FollowCount,
    Todo,
  },
  data () {
    return {
      user: null,
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
    async userShow () {
      const response  = axios.get(`/api/users/${this.id}`)
      const response2 = axios.get(`/api/following/${this.id}`)
      const response3 = axios.get(`/api/follower/${this.id}`)

      const result = await Promise.all([response, response2, response3])

      this.user = result[0].data
      this.isFollowed = result[0].data.is_followed

      this.followings    = result[1].data.reverse()
      this.followCount   = this.followings.length
    
      this.followers     = result[2].data.reverse()
      this.followerCount = this.followers.length

      console.log(result)

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
        await this.userShow()
      },
      immediate: true
    }
  }
}
</script>