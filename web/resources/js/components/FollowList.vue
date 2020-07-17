<template>
  <div>
    <v-virtual-scroll
      :items="list"
      :item-height="65"
      height="270"
    >
      <template v-slot="{ item }">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              <router-link :to="{ name: 'userDetail', params: { id: item.id.toString() }}" class="mypage--link">
                <div @click="userLoading">{{ item.name }}</div>
              </router-link>
            </v-list-item-title>
            <div v-if="item.profile">
              <v-list-item-subtitle v-if="item.profile.content">{{ item.profile.content }}</v-list-item-subtitle>
            </div>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
      </template>
    </v-virtual-scroll>
  </div>
</template>

<script>
export default {
  props: {
    list: {
      type: Array,
      required: true
    }
  },
  created: function () {
    console.log(this.list)
  },
  methods: {
    userLoading () {
      this.$emit('loading')
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