<template>
  <div>
    <div v-if="isFollowing">
      <div v-if="sending" class="spinner-border spinner-border-sm" role="status">
        <v-btn
          class="ma-2"
          tile outlined color="success" 
          disabled
        >
          フォロー中
        </v-btn>
      </div>
      <v-btn
        v-else
        @click="unfollow"
        class="ma-2" tile color="success"
      >
        フォロー中
      </v-btn>
    </div>
    <div v-else>
      <div
        v-if="sending"
        class="spinner-border spinner-border-sm" role="status"
      >
        <v-btn
          class="ma-2"
          tile outlined color="success"
          disabled
        >
          <v-icon left>mdi-plus</v-icon>フォロー
        </v-btn>
      </div>
      <v-btn
        v-else
        @click="follow"
        class="ma-2" tile outlined color="success"
      >
        <v-icon left>mdi-plus</v-icon>フォロー
      </v-btn>
    </div>
    <v-snackbar
      v-model="snackbar"
      :timeout="4000"
    >
      {{ snackbarText }}
    </v-snackbar>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true,
    }
  },
  data () {
    return {
      sending: false,
      isFollowing: this.user.is_following,
      snackbar: false,
      snackbarText: '',
    }
  },
  methods: {
    async follow () {
      this.sending = true

      const response = await axios.post(`/api/follow/${this.user.id}`)

      this.$emit('addFollower')
      this.isFollowing = true
      this.snackbar = true
      this.snackbarText = 'フォローしました'
      this.sending = false
    },
    async unfollow () {
      this.sending = true

      const response = await axios.delete(`/api/unfollow/${this.user.id}`)

      this.$emit('removeFollower')
      this.isFollowing = false
      this.snackbar = true
      this.snackbarText = 'フォローを解除しました'
      this.sending = false
    }
  }
}
</script>