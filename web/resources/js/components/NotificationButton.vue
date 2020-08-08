<template>
  <div v-if="isLogin">
    <div class="position-fixed-left">
      <router-link
        :to="{ name: 'Notification' }"
        style="text-decoration: none;"
      >
        <v-btn
          class="mx-2"
          color="cyan"
          fab dark large
        >
          <div v-if="badegFlag">
            <v-badge
              color="pink"
              :content="notifiCount"
            >
              <v-icon @click="badegFlag = false" class="icon-style">mdi-bell</v-icon>
            </v-badge>
          </div>
          <div v-else>
            <v-icon class="icon-style">mdi-bell</v-icon>
          </div>
        </v-btn>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  data () {
    return {
      badegFlag: false,
      notifiCount: 0,
    }
  },
  created: function () {
    if (this.user) {
      this.addBadegBool()
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    addBadegBool () {
      this.badegFlag = this.user.is_false_notification[0]
      this.notifiCount = this.user.is_false_notification[1]
    }
  }
}
</script>

<style scoped>
.icon-style {
  color: white; 
  text-decoration: none;
}
</style>