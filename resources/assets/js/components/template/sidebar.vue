<template>
	<aside class="main-sidebar">
		<section class="sidebar">
			<div class="user-panel">
				<div class="pull-left image">
					<router-link :to="{ name: 'profile' }">
						<img :src="all.user.logoPath" class="img-circle" alt="#">
					</router-link>
				</div>
				<div class="pull-left info">
					<p>
						<router-link :to="{ name: 'profile' }" style="color: black">
							{{ all.user.fullName }}
						</router-link>
					</p>
						<router-link :to="{ name: 'profile' }">
							<i class="fa fa-circle text-success"></i> En linea.
						</router-link>
				</div>
			</div>

			<rs-menu></rs-menu>

		</section>
	</aside>
</template>

<script>
	import Menu from './sidebar-menu.vue';

	export default {
		name: 'v-sidebar',
		props: ['all'],
		components: {
			'rs-menu': Menu
		}
	}
</script>