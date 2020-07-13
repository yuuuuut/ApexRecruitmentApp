<template>
  <div>
    <div class="d-flex justify-center mt-2">
      <v-chip
        v-if="user.id === currentUser.id && !user.profile"
        class="ma-2 mx-auto"
        color="orange"
        label
        outlined
      >
        プロフィールを作成してみましょう!!
      </v-chip>
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
  computed: {
    currentUser () {
      return this.$store.getters['auth/currentUser']
    }
  }
}
</script>

