<template>
  <div>
    <div v-if="isFollowing">
      <div v-if="sending" class="spinner-border spinner-border-sm" role="status">
        <v-btn class="ma-2" tile outlined color="success" disabled>
          フォロー中
        </v-btn>
      </div>
      <v-btn v-else @click="unfollow" class="ma-2" tile color="success">
        フォロー中
      </v-btn>
    </div>
    <div v-else>
      <div v-if="sending" class="spinner-border spinner-border-sm" role="status">
        <v-btn class="ma-2" tile outlined color="success" disabled>
          <v-icon left>mdi-plus</v-icon>フォロー
        </v-btn>
      </div>
      <v-btn v-else @click="follow" class="ma-2" tile outlined color="success">
        <v-icon left>mdi-plus</v-icon>フォロー
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object
    }
  },
  data () {
    return {
      sending: false,
      isFollowing: this.user.is_following
    }
  },
  computed: {
    currentUser () {
      return this.$store.getters['auth/currentUser']
    }
  },
  methods: {
    async follow () {
      this.sending = true

      const response = await axios.post(`/api/follow/${this.user.id}`)
      //console.log(response)
      this.isFollowing = true
      this.sending = false
    },
    async unfollow () {
      this.sending = true

      const response = await axios.delete(`/api/unfollow/${this.user.id}`)
      //console.log(response)
      this.isFollowing = false
      this.sending = false
    }
  }
}
</script>