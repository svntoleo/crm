<script setup lang="ts">
import { DialogClose, type DialogCloseProps, useForwardProps } from 'reka-ui'
import { computed } from 'vue'
import { Button } from '../button'

const props = defineProps<DialogCloseProps>()

const delegatedProps = computed(() => {
  const { ...delegated } = props
  return delegated
})

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
  <DialogClose
    v-bind="forwardedProps"
    as-child
  >
    <Button variant="outline">
      <slot>Cancel</slot>
    </Button>
  </DialogClose>
</template>
