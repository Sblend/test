<template>
	<div class="h-screen flex-col justify-center relative">
		<div class="absolute right-10 top-10">
			<a href="/logout" class="bg-red-600 text-white p-2 rounded-md">Logout</a>
		</div>
		<div class="min-h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
			<div class="max-w-md w-full space-y-8">
				<div class="bg-green-50 w-full border border-green-900 rounded-md" v-if="message">
					<p class="text-green-900 p-4 text-sm">{{ message }}</p>
				</div>
				<div class="bg-red-50 w-full border border-red-900 rounded-md" v-if="error">
					<p class="text-red-900 p-4 text-sm">{{ error }}</p>
				</div>
				<form class="mt-8 space-y-6">
					<input type="hidden" name="remember" value="true">
					<div class="rounded-md shadow-sm -space-y-px">
						<div>
							<div class="flex justify-between items-center">
								<label for="file" class="text-sm">Upload File</label>
								<span class="text-sm">NB:Only .csv or xlsx is allowed</span>
							</div>
							<input required ref="file" @change="addFile($event)" id="file" name="file" type="file" class="mt-2 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
						</div>
					</div>

					<div>
						<button @click.prevent="uploadFile" type="submit" class="h-12 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							<span v-if="loading">
								<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									width="30px" height="30px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
									<path opacity="0.2" fill="#fff" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
										s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
										c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
									<path fill="#fff" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
										C22.32,8.481,24.301,9.057,26.013,10.047z">
										<animateTransform attributeType="xml"
											attributeName="transform"
											type="rotate"
											from="0 20 20"
											to="360 20 20"
											dur="0.5s"
											repeatCount="indefinite"/>
										</path>
									</svg>
							</span>
							<span v-else class="mt-1.5">Upload</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data(){
			return{
				file:null,
				message:null,
				error:null,
				loading:false
			}
		},
		methods:{
			addFile(e){
				this.file = e.target.files[0]
			},
			
			async uploadFile(){
				try {
					this.loading = true
					let fd = new FormData
					fd.append('file', this.file)
					let response = await axios.post('/upload-file', fd)
					this.$refs.file.value = ''
					this.loading = false
					this.message = response.data
					setTimeout(()=>{
						this.message = null,
						this.error = null
					},10000)
				} catch (error) {
					this.loading = false
					this.error = 'Something went wrong, please try again later'
					setTimeout(()=>{
						this.message = null,
						this.error = null
					},10000)
				}
			}
		}
	}
</script>

<style lang="scss" scoped>
</style>