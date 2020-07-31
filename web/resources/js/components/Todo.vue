<template>
  <div>
    <div v-if="isProfile()">
      <v-snackbar
        :timeout="8000"
        v-model="snackbar"
      >
        プロフィールを作成してみましょう!!
        <template v-slot:action="{ attrs }">
          <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            閉じる
          </v-btn>
        </template>
      </v-snackbar>
    </div>
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
      snackbar: true,
    }
  },
  computed: {
    currentUser () {
      return this.$store.getters['auth/currentUser']
    }
  },
  methods: {
    isProfile () {
      if (this.user.id === this.currentUser.id && !this.user.profile) {
        return true
      }
    },
  }
}
</script>

