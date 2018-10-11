<template>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <select v-model="bro_selected" class="form-control">
                <option v-for="item in bro_list" v-bind:value="item.url">
                    {{ item.text.toUpperCase() }}
                </option>
            </select>
        </li>
        <li class="nav-item">
            <select v-model="test_selected" class="form-control">
                 <optgroup v-for="(tests, key) in test_list" v-bind:label="key">
                    <option v-for="test in tests" v-bind:value="test.url">
                        {{ test.text.replace(/-/g,' ').replace(/_/g,' ').toUpperCase() }}
                    </option>
                </optgroup>
            </select>
        </li>
    </ul>
</template>

<script>
    export default {
        props: [
            'browser_list',
            'test_cases',
            'selected_bro',
            'selected_test',
        ],
        data: function () {
          return {
            bro_list: JSON.parse(this.browser_list),
            bro_selected: this.selected_bro,
            test_list: JSON.parse(this.test_cases),
            test_selected: this.selected_test
          }
        },
        watch: {
            bro_selected: function (newbro, oldbro) {
                this.$emit('browser-changed', newbro)
          },
          test_selected: function (newtest, oldtest) {
                this.$emit('test-changed', newtest)
          }
      },
    }
</script>
