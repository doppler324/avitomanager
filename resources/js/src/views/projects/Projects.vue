<template>
    <div>

        <!-- table -->
        <vue-good-table
            :columns="columns"
            :pagination-options="{
          perPage:pageLength
        }"
            :rows="rows"
            :rtl="direction"
            :search-options="{
          enabled: true,
          externalQuery: searchTerm
        }"
            :select-options="{
          enabled: true,
          selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
          selectionInfoClass: 'custom-class',
          selectionText: 'rows selected',
          clearSelectionText: 'clear',
          disableSelectInfo: true, // disable the select info panel on top
          selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
        }"
        >
            <template
                v-slot:table-row="props"
            >

                <!-- Column: Name -->
                <span
                    v-if="props.column.field === 'fullName'"
                    class="text-nowrap"
                >
          <b-avatar
              :src="props.row.avatar"
              class="mx-1"
          />
          <span class="text-nowrap">{{ props.row.fullName }}</span>
        </span>

                <!-- Column: Status -->
                <span v-else-if="props.column.field === 'status'">
          <b-badge :variant="statusVariant(props.row.status)">
            {{ props.row.status }}
          </b-badge>
        </span>

                <!-- Column: Action -->
                <span v-else-if="props.column.field === 'action'">
          <span>
            <b-dropdown
                no-caret
                toggle-class="text-decoration-none"
                variant="link"
            >
              <template v-slot:button-content>
                <feather-icon
                    class="text-body align-middle mr-25"
                    icon="MoreVerticalIcon"
                    size="16"
                />
              </template>
              <b-dropdown-item>
                <feather-icon
                    class="mr-50"
                    icon="Edit2Icon"
                />
                <span>Edit</span>
              </b-dropdown-item>
              <b-dropdown-item>
                <feather-icon
                    class="mr-50"
                    icon="TrashIcon"
                />
                <span>Удалить</span>
              </b-dropdown-item>
            </b-dropdown>
          </span>
        </span>

                <!-- Column: Common -->
                <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
            </template>

            <!-- pagination -->
            <template
                v-slot:pagination-bottom="props"
            >
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-0 mt-1">
            <span class="text-nowrap ">
              Показать 1 из
            </span>
                        <b-form-select
                            v-model="pageLength"
                            :options="['10','50','100']"
                            class="mx-1"
                            @input="(value)=>props.perPageChanged({currentPerPage:value})"
                        />
                        <span class="text-nowrap"> из {{ props.total }} проектов </span>
                    </div>
                    <div>
                        <b-pagination
                            :per-page="pageLength"
                            :total-rows="props.total"
                            :value="1"
                            align="right"
                            class="mt-1 mb-0"
                            first-number
                            last-number
                            next-class="next-item"
                            prev-class="prev-item"
                            @input="(value)=>props.pageChanged({currentPage:value})"
                        >
                            <template #prev-text>
                                <feather-icon
                                    icon="ChevronLeftIcon"
                                    size="18"
                                />
                            </template>
                            <template #next-text>
                                <feather-icon
                                    icon="ChevronRightIcon"
                                    size="18"
                                />
                            </template>
                        </b-pagination>
                    </div>
                </div>
            </template>
            <div slot="emptystate" class="text-center">
                <span class="clearfix">У Вас нет проектов</span>
                <b-button
                    v-b-modal.modal-1
                    v-ripple.400="'rgba(40, 199, 111, 0.15)'"
                    class="mt-1"
                    size="sm"
                    variant="outline-success"
                >
                    <feather-icon icon="PlusCircleIcon"/>
                    Добавить
                </b-button>
                <b-modal id="modal-1" title="Добавить проект">
<<<<<<< HEAD
=======

>>>>>>> origin/projects
                </b-modal>
            </div>
        </vue-good-table>
    </div>

</template>

<script>
import {
    BAvatar, BModal, BButton, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem,
} from 'bootstrap-vue'
import {VueGoodTable} from 'vue-good-table'
import store from '@/store/index'
import Ripple from 'vue-ripple-directive'

export default {
    components: {

        VueGoodTable,
        BAvatar,
        BBadge,
        BModal,
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BButton,
    },
    directives: {
        Ripple,
    },
    data() {
        return {
            menuHidden: this.$store.state.appConfig.layout.menu.hidden,
            pageLength: 10,
            dir: false,
            columns: [
                {
                    label: 'Name',
                    field: 'fullName',
                },
                {
                    label: 'Email',
                    field: 'email',
                },
                {
                    label: 'Date',
                    field: 'startDate',
                },
                {
                    label: 'Salary',
                    field: 'salary',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ],
            rows: [],
            searchTerm: '',
            status: [{
                1: 'Current',
                2: 'Professional',
                3: 'Rejected',
                4: 'Resigned',
                5: 'Applied',
            },
                {
                    1: 'light-primary',
                    2: 'light-success',
                    3: 'light-danger',
                    4: 'light-warning',
                    5: 'light-info',
                }],
        }
    },
    methods: {},
    computed: {
        statusVariant() {
            const statusColor = {
                /* eslint-disable key-spacing */
                Current: 'light-primary',
                Professional: 'light-success',
                Rejected: 'light-danger',
                Resigned: 'light-warning',
                Applied: 'light-info',
                /* eslint-enable key-spacing */
            }

            return status => statusColor[status]
        },
        direction() {
            if (store.state.appConfig.isRTL) {
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.dir = true
                return this.dir
            }
            // eslint-disable-next-line vue/no-side-effects-in-computed-properties
            this.dir = false
            return this.dir
        },
    },
    created() {
        this.$store.commit('appConfig/UPDATE_NAV_MENU_HIDDEN', true)
        this.$http.get('/projects')
            .then(res => {
                this.rows = res.data
            })
    },
    destroyed() {
        // Restore the state value of `appConfig` when page/SFC is destroyed
        this.$store.commit('appConfig/UPDATE_NAV_MENU_HIDDEN', this.menuHidden)
    },
}
</script>
<style lang="scss">
@import '~@resources/scss/vue/libs/vue-good-table.scss';
</style>
