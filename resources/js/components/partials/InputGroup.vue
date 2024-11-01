<template>
    <div class="form-group" :class="className">
        <label v-if="label">{{ $t(label) }}
            <span v-if="required == true" class="error">*</span>
        </label>
        <input
            :type="type"
            :name="name"
            class="form-control"
            :placeholder="$t(placeholder)"
            @input="updateInput"
            :value="modelValue"
            :required="required"
        />
        <input-errors :name="name" :errors="errors"></input-errors>
    </div>
</template>
<script>
import InputErrors from "./InputErrors.vue";
export default {
    components: { InputErrors },
    name: "InputGroup",
    props: [
        "id",
        "class",
        "label",
        "modelValue",
        "placeholder",
        "type",
        "required",
        "name",
        "index",
        "errors",
    ],

    data() {
        return {
            className: this.class,
        };
    },

    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        },

        errorPlainText(errorMsg) {
            const msg = errorMsg.replace("0", " ").split(".").join("");
            return msg;
        },
    },
};
</script>
