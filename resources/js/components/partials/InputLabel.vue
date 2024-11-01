<template>
    <label :for="labelFor"
        >{{ $t(label) }}
        <span v-if="required == true" class="error">*</span>
    </label>
</template>
<script>
export default {
    name: "InputLabel",
    props: {
        label: {
            type: String,
            default: "",
        },
        labelFor: {
            type: String,
            default: "",
        },
        required: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
<style></style>
