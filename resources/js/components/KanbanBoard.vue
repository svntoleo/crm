<script setup lang="ts">
import { ref, watch } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { VueDraggable } from 'vue-draggable-plus';

interface Document {
  id: number;
  title: string;
  number?: string;
  customer?: { name: string };
  stage_id: number;
  position: number;
  total: number;
}

interface Stage {
  id: number;
  label: string;
  order: number;
}

interface Props {
  documents: Document[];
  stages: Stage[];
  onMove?: (moves: Array<{ id: number; stage_id: number; position: number }>) => void;
  onCardClick?: (documentId: number) => void;
}

const props = withDefaults(defineProps<Props>(), {});

// Create mutable copies of documents for each stage
const stageDocuments = ref<Record<number, Document[]>>({});

// Initialize stage documents on mount and when props change
watch(
  () => props.documents,
  () => {
    const grouped: Record<number, Document[]> = {};
    
    props.stages.forEach((stage) => {
      grouped[stage.id] = [];
    });

    props.documents.forEach((doc) => {
      if (grouped[doc.stage_id]) {
        grouped[doc.stage_id].push(doc);
      }
    });

    // Sort by position within each stage
    Object.keys(grouped).forEach((key) => {
      grouped[parseInt(key)].sort((a, b) => a.position - b.position);
    });

    stageDocuments.value = grouped;
  },
  { immediate: true }
);

function handleMoveEnd() {
  // Collect all moves from all stages
  const allMoves: Array<{ id: number; stage_id: number; position: number }> = [];
  
  Object.keys(stageDocuments.value).forEach((stageIdStr) => {
    const stageId = parseInt(stageIdStr);
    const items = stageDocuments.value[stageId] || [];
    
    items.forEach((doc, index) => {
      const newPosition = (index + 1) * 100;
      // Check if document moved to different stage or position changed
      const originalDoc = props.documents.find(d => d.id === doc.id);
      if (originalDoc && (originalDoc.stage_id !== stageId || originalDoc.position !== newPosition)) {
        allMoves.push({
          id: doc.id,
          stage_id: stageId,
          position: newPosition,
        });
      }
    });
  });

  if (allMoves.length > 0 && props.onMove) {
    props.onMove(allMoves);
  }
}
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <Card v-for="stage in props.stages" :key="stage.id" class="min-h-96">
      <CardHeader>
        <CardTitle class="text-sm">{{ stage.label }}</CardTitle>
      </CardHeader>
      <CardContent class="space-y-2">
        <VueDraggable
          v-model="stageDocuments[stage.id]"
          group="documents"
          :animation="150"
          class="space-y-2 min-h-[300px]"
          @end="handleMoveEnd"
        >
          <div
            v-for="document in stageDocuments[stage.id]"
            :key="document.id"
            class="p-4 bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:shadow-lg hover:border-blue-300 transition-all duration-200"
            @click="props.onCardClick?.(document.id)"
          >
            <div class="flex items-start justify-between mb-2">
              <div class="font-medium text-gray-900">{{ document.title || document.number || `#${document.id}` }}</div>
            </div>
            <div class="text-sm text-gray-600 mb-2">{{ document.customer?.name ?? 'No customer' }}</div>
            <div class="text-lg font-bold text-blue-600">R$ {{ Number(document.total).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }}</div>
          </div>
        </VueDraggable>
      </CardContent>
    </Card>
  </div>
</template>
