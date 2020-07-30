<template>
  <div>
    <v-card
      class="mx-auto mt-4"
      width="600px"
    >
      <v-card-text>
        <div class="d-flex flex-row">
          <div v-if="item.platform">
            {{ item.platform }}
          </div>
          <div v-if="item.myid" class="ml-4">
            ID: {{ item.myid }}
          </div>
          <div v-else class="ml-4">
            ID: 未設定
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
            {{ item.content }}
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

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
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