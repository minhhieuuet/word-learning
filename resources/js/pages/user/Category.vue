<template>
<data-table :get-data="getData" ref="datatable">
    <th class="col_checkbox">
        <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
    </th>
    <th class="col_title_en">Tiêu đề</th>
    <th class="col_title_jp">Hình ảnh</th>
    <th>Ngày tạo</th>
    <th class="col_tools">Công cụ</th>
    <template slot="body" slot-scope="{ item, index }">
        <tr>
            <td class="text-center">
                <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
            </td>
            <td class="text-center" v-html="item.title"></td>
            <td class="text-center">
                <img style="max-width: 200px;" :src="item.image"/>
            </td>
            <td class="text-center" v-html="item.created_at"></td>
            <td class="text-center">
                <md-button class="md-just-icon md-simple md-primary" @click="editStudent(item.id)">
                    <md-icon>edit</md-icon>
                    <md-tooltip md-direction="top">Sửa</md-tooltip>
                </md-button>
                <md-button class="md-just-icon md-simple md-danger" @click="removeOneStudent(item.id)">
                    <md-icon>close</md-icon>
                    <md-tooltip md-direction="top">Xóa</md-tooltip>
                </md-button>
            </td>
        </tr>
    </template>
</data-table>
</template>

<script>
import rf from './../../requests/RequestFactory';
export default {
    data () {
        return {
            params: {}
        }
    },
    methods: {
        getData(params) {
            const meta = Object.assign({}, params, {
                search: this.searchInput,
            });
            return rf.getRequest('CategoryRequest').getCategories(meta);
        },
    }
}
</script>

<style lang="css">
.ant-card-bordered {
    display: inline-block;
    margin-bottom: 20px;
}

.ant-row-flex {
    margin-bottom: 30px;
}
</style>
