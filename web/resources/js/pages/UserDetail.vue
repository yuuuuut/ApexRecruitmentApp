<template>
  <div v-if="dataReady">
    <Todo :user="user" />
    <v-card
    class="mx-auto mt-4"
    width="720px"
    outlined>
      <v-list-item three-line>
        <v-list-item-content>
          <div class="d-flex justify-space-between">
            <v-list-item-title class="headline mb-3">{{ user.name }}</v-list-item-title>
            <div v-if="currentUser.id === user.id">
              <ProfileForm />
            </div>
          </div>
          <div v-if="user.profile">
            <div class="blue-grey--text text--lighten-1" v-if="user.profile.content">{{ user.profile.content }}</div>
            <div class="pt-3">
              <v-list-item-subtitle v-if="user.profile.platform">
                <v-icon>mdi-laptop-mac</v-icon>PlatForm {{ user.profile.platform }}
              </v-list-item-subtitle>
              <v-list-item-subtitle v-if="user.profile.platform === 'PS4'">
                <v-icon>mdi-video-input-antenna</v-icon>PSID: {{ user.profile.psid }}
              </v-list-item-subtitle>
              <v-list-item-subtitle v-else-if="user.profile.platform === 'PC'">
                <v-icon>mdi-video-input-antenna</v-icon>OriginID: {{ user.profile.originid }}
              </v-list-item-subtitle>
            </div>
          </div>
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
    Todo
  },
  data () {
    return {
      user: null,
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
      const response = await axios.get(`/api/users/${this.id}`)
      console.log(response)
      this.user = response.data
      this.dataReady = true
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