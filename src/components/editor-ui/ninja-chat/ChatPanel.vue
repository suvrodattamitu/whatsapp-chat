<template>
	<div class="container">
		<design1 :all_configs="all_configs" :members="members"></design1>
	</div>
</template>

<script type="text/babel">
import Design1 from './Design1'
import Design2 from './Design2'
import Design3 from './Design3'

export default {
	props:['all_configs','members'],
	components:{
		Design1,
		Design2,
		Design3
	}
}
</script>