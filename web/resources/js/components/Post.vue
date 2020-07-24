<template>
  <div>
    <v-card
      class="mx-auto mt-4"
      width="600px"
    >
      <v-card-text>
        <div class="d-flex flex-row">
          <div>{{ item.platform }}</div>
          <div v-if="item.myid" class="ml-4">ID: {{ item.myid }}</div>
          <div v-else class="ml-4">ID: 未設定</div>
        </div>
        <h2 class="text--primary">
          <router-link :to="{ name: 'userDetail', params: { id: item.user.id.toString() }}" class="mypage--link">
            {{ item.user.name }}
          </router-link>
        </h2>
        <h3 class="blue-grey--text text--lighten-2 mt-2">
          {{ item.content }}
        </h3>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>
.mypage--link {
  color: black;
  text-decoration: none;
}
</style>