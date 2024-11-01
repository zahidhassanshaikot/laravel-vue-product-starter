<template>
    <input
        type="text"
        :name="name"
        class="form-control"
        :placeholder="$t(placeholder)"
        @input="updateInput"
        :value="modelValue"
        :required="required"
    />
    <p v-if="haveErrors" class="error">{{ errors?.[name] }}</p>
</template>
<script>
export default {
    props: {
        id: {
            type: [Number, String],
            default: "",
        },
        class: {
            type: String,
            default: "",
        },
        modelValue: {
            type: [String, Number],
            default: "",
        },
        type: {
            type: String,
            default: "text",
        },
        placeholder: {
            type: String,
            default: "Placeholder..",
        },
        required: {
            type: Boolean,
            default: false,
        },
        name: {
            type: String,
            default: false,
        },
        errors: {
            type: [Object, Array],
            default: [],
        },
    },
    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },

    computed:{
        haveErrors(){
            let status = false;
            if (typeof this.errors != undefined) {
                status =  this.errors && this.errors?.[this.name] ? true : false;
            }
            return status;
        }
    }
};
</script>
<style></style>
