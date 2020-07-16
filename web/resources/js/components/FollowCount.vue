<template>
  <div v-if="!loading">
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
          :items="this.user.followings"
          :item-height="73"
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
          </template>
        </v-virtual-scroll>
      </v-card>
    </v-dialog>
  </div>
  <div v-else>
    <v-overlay :value="overlay">
      <v-text-field color="success" loading disabled></v-text-field>
    </v-overlay>
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
      loading: false,
      overlay: false,
    }
  },
  /*
  created: function () {
    console.log(this.user.followings)
  },
  */
  methods: {
    userLoading () {
      this.loading = true
      this.overlay = true

      setTimeout(function () {
        this.dialog = false
        this.loading = false
        this.overlay = false
      }.bind(this), 3500);
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