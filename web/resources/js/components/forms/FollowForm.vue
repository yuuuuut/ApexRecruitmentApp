<template>
  <div>
    <button v-if="isFollowing" type="button" class="btn btn-point btn-raised" @click="unfollow">
      <div v-if="sending" class="spinner-border spinner-border-sm" role="status">
        <span class="sr-only">Sending...</span>
      </div>
      <v-btn v-else class="ma-2" tile color="success">
        フォロー中
      </v-btn>
    </button>
    <button v-else type="button" @click="follow">
      <div v-if="sending" class="spinner-border spinner-border-sm" role="status">
        <span class="sr-only">Sending...</span>
      </div>
      <v-btn v-else class="ma-2" tile outlined color="success">
        <v-icon left>mdi-plus</v-icon>フォロー
      </v-btn>
    </button>
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