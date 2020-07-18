<template>
  <div>
    <div v-if="user.id === currentUser.id && !user.profile" class="ma-2 mx-auto">
      <v-snackbar :timeout="8000" v-model="snackbar">
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
  }
}
</script>

