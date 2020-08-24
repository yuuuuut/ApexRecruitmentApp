<template>
  <div v-if="loading" class="mt-5">
    <div
      v-for="n in notifications"
      :key="n.id"
    >
      <v-card
        class="mx-auto mb-3"
        width="600px"
        outlined
      >
        <v-card-text>
          <div v-if="n.action === 'follow'">
            <router-link
              :to="{ name: 'userDetail', params: { id: n.visiter.id.toString() }}" 
              class="grey--text text--darken-3"
              style="text-decoration: none;"
            >
              {{ n.visiter.name }}さんにフォローされました
            </router-link>
          </div>
          <div v-if="n.action === 'post'">
            <router-link
              :to="{ name: 'userDetail', params: { id: n.visiter.id.toString() }}" 
              class="grey--text text--darken-3"
              style="text-decoration: none;"
            >
              {{ n.visiter.name }}さんが募集しています
            </router-link>
          </div>
          <div class="d-flex flex-row-reverse">
            {{ n.created_at | moment }}
          </div>
        </v-card-text>
      </v-card>
    </div>
    <div
      v-if="notifications.length === 0"
      class="text-h5 blue-grey--text text--lighten-1"
      style="text-align: center;"
    >
      通知はありません
    </div>
  </div>
  <div v-else>
    <div class="mt-5" style="text-align: center;">
      <v-progress-circular
        indeterminate
        color="purple"
      ></v-progress-circular>
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  data () {
    return {
      notifications: [],
      loading: false
    }
  },
  filters: {
    moment: function (date) {
      moment.locale( 'ja' )
      return moment(date).fromNow()
    }
  },
  methods: {
    async getNotification () {
      const response = await axios.get(`/api/notification`)

      this.notifications = response.data
      this.loading = true
      console.log(this.notifications)
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.getNotification()
      },
      immediate: true
    }
  }
}

</script>