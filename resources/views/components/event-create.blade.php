<!-- component -->
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<div class=" min-h-screen flex  justify-center bg-center  py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 bg-no-repeat bg-cover relative items-center">
    	<div class="absolute bg-gray-900 opacity-60 inset-0 z-0"></div>
	<div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
<div class="grid  gap-8 grid-cols-1">
	<div class="flex flex-col ">
			<div class="flex flex-col sm:flex-row items-center">
				<h2 class="font-semibold text-lg mr-auto">Event Info</h2>
				<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
			</div>
			<div class="mt-5">
				<div class="form">
					<div class="md:space-y-2 mb-3">
						<label class="text-xs font-semibold text-gray-600 py-2">Event Picture<abbr class="hidden" title="required">*</abbr></label>
						<div class="flex items-center py-6">
							<div class="w-12 h-12 mr-4 flex-none rounded-xl border overflow-hidden">
								<img class="w-12 h-12 mr-4 object-cover" src="https://images.unsplash.com/photo-1611867967135-0faab97d1530?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1352&amp;q=80" alt="Avatar Upload">
                </div>
								<label class="cursor-pointer ">
                  <span class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Browse</span>
                  <input type="file" class="hidden" :multiple="multiple" :accept="accept">
                </label>
							</div>
						</div>
						<div class="md:flex flex-row md:space-x-4 w-full text-xs">
							<div class="mb-3 space-y-2 w-full text-xs">
								<label class="font-semibold text-gray-600 py-2">Event Title <abbr title="required">*</abbr></label>
								<input placeholder="Event Title" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="integration[shop_name]" id="integration_shop_name">
								<p class="text-red text-xs hidden">Please fill out this field.</p>
							</div>
							<div class="mb-3 space-y-2 w-full text-xs">
								<label class="font-semibold text-gray-600 py-2">Event Date <abbr title="required">*</abbr></label>
								<input type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="integration[shop_name]" id="integration_shop_name">
								<p class="text-red text-xs hidden">Please fill out this field.</p>
							</div>
						</div>
						
							
							<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
								<div class="w-full flex flex-col mb-3">
									<label class="font-semibold text-gray-600 py-2">Event Address</label>
									<input placeholder="Address" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" type="text" name="integration[street_address]" id="integration_street_address">
              </div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-semibold text-gray-600 py-2">Location<abbr title="required">*</abbr></label>
										<select class="block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 md:w-full " required="required" name="integration[city_id]" id="integration_city_id">
                  <option value="">Seleted location</option>
                  <option value="">Glasgow</option>
                  <option value="">Edinburgh</option>
                  <option value="">Aberdeen</option>
                    <option value="">Dundee</option>
                    <option value="">Stirling</option>
                    <option value="">Inverness</option>
                    <option value="">Perth</option>
                    <option value="">St Andrews</option>
                    <option value="">Fort William</option>
                    <option value="">Oban</option>
                    <option value="">Pitlochry</option>
                    <option value="">Dunfermline</option>
                    <option value="">Kirkcaldy</option>
                </select>
										<p class="text-sm text-red-500 hidden mt-3" id="error">Please fill out this field.</p>
									</div>
								</div>
								<div class="flex-auto w-full mb-1 text-xs space-y-2">
									<label class="font-semibold text-gray-600 py-2">Description</label>
									<textarea required="" name="message" id="" class="w-full min-h-[100px] max-h-[300px] h-28 appearance-none block  bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4" placeholder="Give more information about the event" spellcheck="false"></textarea>
									<p class="text-xs text-gray-400 text-left my-3">You inserted 0 characters</p>
								</div>
								<div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                                    <div class="w-full flex flex-col mb-3">
                                        <label class="font-semibold text-gray-600 py-2">Start Time</label>
                                        <input type="time" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="integration[street_address]" id="integration_street_address">
                                        <p class="text-sm text-red-500 hidden mt-3" id="error">Please fill out this field.</p>
                                    </div>
                                    <div class="w-full flex flex-col mb-3">
                                        <label class="font-semibold text-gray-600 py-2">End Time</label>
                                        <input type="time" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="integration[street_address]" id="integration_street_address">
                                        <p class="text-sm text-red-500 hidden mt-3" id="error">Please fill out this field.</p>
                                    </div>
								
							</div>
                            <div class="mt-5 text-right md:space-x-3 md:block flex flex-col-reverse">
									<button class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500">Save</button>
								</div>
						</div>
					</div>
				</div>
			</div>