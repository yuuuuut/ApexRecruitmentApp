<template>
  <div v-if="!loading">
    <div class="d-flex justify-start">
      <div @click.stop="FollowingDialog = true" class="grey--text text--darken-1">{{ this.followCount }}フォロー中</div>
      <v-divider
        class="mx-4"
        vertical
      ></v-divider>
      <div @click.stop="FollowerDialog = true" class="grey--text text--darken-1">{{ this.followerCount }}フォロワー</div>
    </div>
    <v-dialog v-model="FollowingDialog" width="360">
      <v-card>
        <FollowList 
          :list="followings"
          @loading="loadingUser" 
        />
      </v-card>
    </v-dialog>
    <v-dialog v-model="FollowerDialog" width="360">
      <v-card>
        <FollowList 
          :list="followers"
          @loading="loadingUser" 
        />
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
import FollowList from '../components/FollowList.vue'

export default {
  props: {
    followCount: {
      type: Number
    },
    followerCount: {
      type: Number
    },
    followings: {
      type: Array
    },
    followers: {
      type: Array
    }
  },
  components: {
    FollowList,
  },
  data () {
    return {
      FollowingDialog: false,
      FollowerDialog: false,
      loading: false,
      overlay: false,
    }
  },
  methods: {
    loadingUser () {
      this.loading = true
      this.overlay = true

      setTimeout(function () {
        this.FollowingDialog = false
        this.FollowerDialog  = false
        this.loading = false
        this.overlay = false
      }.bind(this), 2000);
    }
  }
}
</script>