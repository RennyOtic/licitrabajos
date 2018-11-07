<template>
    <div class="form-group">
        <label :for="input.id" class="control-label">
            <span :class="input.icon"></span> {{ input.label }}
        </label>
        <input :id="input.id"
        class="form-control"
        :class="input.class"
        :type="(input.type) ? input.type : 'text'"
        :placeholder="input.label"
        :required="input.required"
        :accept="input.accept"
        :value="value"
        :min="input.min"
        :max="input.max"
        :readonly="input.readonly"
        :disabled="input.disabled"
        @input="updateValue($event.target.value)">
        <small :id="input.id + 'Help'" class="form-text text-muted">{{ msg }}</small>
    </div>
</template>

<script>
    export default {
        name: 'input-form',
        props: {
            input: {},
            msg: {},
            value: {},
        },
        methods: {
            updateValue: function (value) {
                this.$emit('input', value);
            }
        }
    }
</script>
