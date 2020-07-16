<template>
  <div>
    <div class="d-flex justify-start">
      <div @click.stop="dialog = true">{{ this.followingCount }}</div>フォロー中
      <v-divider
        class="mx-4"
        vertical
      ></v-divider>
      {{ this.followersCount }}フォロワー
    </div>
    <v-dialog
      v-model="dialog"
      max-width="290"
    >
      <v-card>
        <v-virtual-scroll
          :items="this.user.followings.data"
          :item-height="73"
          height="270"
        >
          <template v-slot="{ item }">
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <router-link :to="{ name: 'userDetail', params: { id: item.id.toString() }}" class="mypage--link">
                    <div @click="dialog = false">{{ item.name }}</div>
                  </router-link>
                </v-list-item-title>
                <div v-if="item.profile">
                  <v-list-item-subtitle v-if="item.profile.content">{{ item.profile.content }}</v-list-item-subtitle>
                </div>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-virtual-scroll>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object
    },
    followingCount: {
      type: Number
    },
    followersCount: {
      type: Number
    }
  },
  data () {
    return {
      dialog: false,
    }
  },
  created: function () {
    console.log(this.user.followings)
  }
}
</script>

<style scoped>
.mypage--link {
  color: black;
  text-decoration: none;
}
</style>