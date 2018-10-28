<template>
	<div class="row">
		<div class="col-md-12">
			<header-table :n="n" :c="nc" @changeN="num = arguments[0]" @changeS="search = arguments[0]"></header-table>
			<div class="table-responsive">
				<table :id="id" class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th v-for="column in columns">{{ column.title }} <span class="fa fa-angle-left pull-right btn-xs" v-if="column.sortable" @click="sort(column,$event)"></span></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="r in rows" @click="selectRow(r)">
							<td v-if="rs == 1" v-for="column in columns" v-html="textColum(r, column)" :class="column.class"></td>
							<td v-if="rs == 2"><rs-item :data="r"></rs-item></td>
						</tr>
					</tbody>
				</table>
				<pagination :data="pagination" @change="get(arguments[0])"></pagination>
			</div>
		</div>
	</div>
</template>

<style scoped="">
th span, tbody tr {
	cursor: pointer;
}
</style>

<script>
	import Pagination from './pagination.vue';
	import HeaderTable from './header-table.vue';
	import Item from './licitacion.vue';

	export default {
		name: 'v-table',
		components: {
			'pagination': Pagination,
			'header-table': HeaderTable,
			'rs-item': Item
		},
		// computed: {
		// 	asd: function () {
		// 		return this.rs;
		// 	}
		// },
		props: {
			uri: {},
			columns: {},
			id: {},
			num_id: {},
			rs: {
				default: function () {
					return 1;
				}
			},
			n: {
				default: function () {
					return [10,20,30];
				}
			},
			nc: {
				default: 10
			}
		},
		data() {
			return {
				rows: [],
				num: 10,
				search: '',
				dir: '',
				order: '',
				pagination: {
					'total': 0,
					'to': 0,
					'from': 0,
					'per_page': 0,
					'current_page': 0,
					'last_page': 0
				},
			}
		},
		watch: {
			search: _.debounce(function () {this.get();}, 500),
			num: function () {this.get();}
		},
		mounted() {
			this.get();
		},
		methods: {
			selectRow: function (row) {
				this.$emit('output', row.id);
			},
			textColum: function (data, column) {
				let searchPoint = column.field.split('.');
				if (searchPoint.length > 1) {
					return data[searchPoint[0]][searchPoint[1]];
				}
				return data[column.field];
			},
			sort: function (colum, e) {
				$('.fa.fa-angle-left.pull-right').css('transform', 'rotate(	0deg)');
				if (this.dir == 'ASC') {
					this.dir = 'DESC';
					$(e.target).css('transform', 'rotate(-90deg)');
				} else {
					this.dir = 'ASC';
					$(e.target).css('transform', 'rotate(90deg)');
				}
				if (colum.sort) {
					this.order = colum.sort;
				} else {
					this.order = colum.field;
				}
				this.get();
			},
			get: function (page = null) {
				let url =  this.uri + '?';
				if (page) url += '&page=' + page;
				if (this.num) url += '&num=' + this.num;
				if (this.search) url += '&search=' + this.search;
				if (this.dir) url += '&dir=' + this.dir;
				if (this.order) url += '&order=' + this.order;
				if (this.num_id) url += '&num_id=' + this.num_id;
				$('tbody tr').removeClass('active');
				this.$emit('output', false);
				axios.get(url)
				.then(response => {
					this.rows = response.data.data;
					this.pagination = response.data.pagination;
				})
				.then(() => {
					$('tbody tr').click(function () {
						$('tbody tr').removeClass('active');
						$(this).addClass('active');
					});
				});
			}
		}
	}
</script>