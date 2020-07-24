<template>
  <div>
    {{ item.content }}
    {{ item.user.name }}
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