import { ref } from "vue";

export function useCollection(emits) {
    const items = ref([]);

    const add = (item) => {
        items.value.push(item);
        emits('added');
    };
    
    const remove = index => {
        items.value.splice(index, 1);
        emits('removed');
    };

    return { items, add, remove };
};
