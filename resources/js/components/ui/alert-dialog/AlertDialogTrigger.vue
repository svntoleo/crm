<script setup lang="ts">
import { DialogTrigger, type DialogTriggerProps } from 'reka-ui'

const props = defineProps<DialogTriggerProps>()
</script>

<template>
  <DialogTrigger
    data-slot="alert-dialog-trigger"
    v-bind="props"
    as-child
  >
    <slot />
  </DialogTrigger>
</template>
