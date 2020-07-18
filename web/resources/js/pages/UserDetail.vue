<template>
  <div v-if="dataReady">
    <Todo :user="user" />
    <v-card
      class="mx-auto mt-4"
      width="720px"
      outlined
    >
      <v-list-item three-line>
        <v-list-item-content>
          <div class="d-flex justify-space-between">
            <v-list-item-title class="headline">{{ user.name }}</v-list-item-title>
            <div v-if="currentUser.id === user.id">
              <ProfileForm
                @reloadUser="userShow"
              />
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
            <div v-if="currentUser.id !== user.id">
              <FollowForm 
                :user="user"
                @addCount="addFollowerCount"
                @removeCount="removeFollowerCount"
              />
            </div>
          </div>

          <div v-if="user.profile">
            <div class="blue-grey--text text--lighten-1" v-if="user.profile.content">{{ user.profile.content }}</div>
            <div class="pt-3">
              <v-list-item-subtitle v-if="user.profile.platform">
                <v-icon>mdi-laptop-mac</v-icon>{{ user.profile.platform }}
              </v-list-item-subtitle>
              <v-list-item-subtitle v-if="user.profile.platform === 'PS4'">
                <v-icon>mdi-video-input-antenna</v-icon>PSID: {{ user.profile.psid }}
              </v-list-item-subtitle>
              <v-list-item-subtitle v-else-if="user.profile.platform === 'PC'">
                <v-icon>mdi-video-input-antenna</v-icon>OriginID: {{ user.profile.originid }}
              </v-list-item-subtitle>
            </div>
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
      followings: null,
      followers: null,
      followCount: 0,
      followerCount: 0,
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
      const response  = await axios.get(`/api/users/${this.id}`)
      this.user = response.data

      const response2 = await axios.get(`/api/following/${this.id}`)
      this.followings    = response2.data
      this.followCount   = response2.data.length
    
      const response3 = await axios.get(`/api/follower/${this.id}`)
      this.followers     = response3.data
      this.followerCount = response3.data.length

      console.log(response)
      console.log(response2)
      console.log(response3)

      this.dataReady = true
    },
    addFollowerCount () {
      this.followerCount += 1
    },
    removeFollowerCount () {
      this.followerCount -= 1
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