<template>
  <div>
    <v-card
      class="mx-auto mt-4"
      width="600px"
    >
      <v-card-text>
        <div class="d-flex flex-row">
          <div v-if="item.platform">
            <div v-show="item.platform === 'PS4'">
              <v-chip
                class="mb-2"
                color="pink"
                label
                text-color="white"
                small
              >
                {{ item.platform }}
              </v-chip>
            </div>
            <div v-show="item.platform === 'PC'">
              <v-chip
                class="mb-2"
                color="blue"
                label
                text-color="white"
                small
              >
                {{ item.platform }}
              </v-chip>
            </div>
          </div>

          <div v-if="isLogin">
            <div v-if="item.myid" class="ml-4">
              ID: {{ item.myid }}
            </div>
          </div>
          <div v-else>
            <div v-if="item.myid" class="ml-4">
              <div v-if="item.private === 1">
                ID: ログインユーザーにのみ表示
              </div>
              <div v-else-if="item.private === 0">
                ID: {{ item.myid }}
              </div>
            </div>
          </div>
        </div>
        <h2 class="text--primary">
          <router-link
            :to="{ name: 'userDetail', params: { id: item.user.id.toString() }}" 
            class="mypage--link grey--text text--darken-3"
          >
            {{ item.user.name }}
          </router-link>
        </h2>
        <h3 class="blue-grey--text text--lighten-2 mt-2">
          <routerLink
            :to="{ name: 'postDetail', params: { id: item.id.toString() }}" 
            class="mypage--link blue-grey--text text--lighten-1"
          >
            <div style="white-space: pre-wrap;">{{ item.content }}</div>
          </routerLink>
        </h3>
        <div class="d-flex flex-row-reverse mt-2">
          {{ item.updated_at | moment }}
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters } from 'vuex'

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  filters: {
    moment: function (date) {
      moment.locale( 'ja' )
      return moment(date).fromNow()
    }
  }
}
</script>

<style scoped>
.mypage--link {
  text-decoration: none;
}
</style>