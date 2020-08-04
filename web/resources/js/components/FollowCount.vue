<template>
  <div>
    <div class="d-flex justify-start">
      <div
        @click.stop="FollowingDialog = true"
        class="grey--text text--darken-1"
      >
        {{ this.followCount }}フォロー中
      </div>
      <v-divider
        class="mx-4"
        vertical
      ></v-divider>
      <div
        @click.stop="FollowerDialog = true"
        class="grey--text text--darken-1"
      >
        {{ this.followerCount }}フォロワー
      </div>
    </div>
    <!-- FollowUser -->
    <v-dialog v-model="FollowingDialog" width="360">
      <v-card>
        <FollowList 
          :list="followings"
        />
      </v-card>
    </v-dialog>
    <!-- FollowerUser -->
    <v-dialog v-model="FollowerDialog" width="360">
      <v-card>
        <FollowList 
          :list="followers"
        />
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import FollowList from '../components/FollowList.vue'

export default {
  props: {
    followCount: {
      type: Number,
      required: true,
    },
    followerCount: {
      type: Number,
      required: true,
    },
    followings: {
      type: Array,
      required: true,
    },
    followers: {
      type: Array,
      required: true,
    }
  },
  components: {
    FollowList,
  },
  data () {
    return {
      FollowingDialog: false,
      FollowerDialog: false,
    }
  }
}
</script>