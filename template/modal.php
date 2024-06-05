[modal]
<div id="myModal" class="modal">
	<div>
		<div class="blockTitle2 text-center">{modalTitle}</div>

		<div class="modalСontent text-center">
			{modalBody}
		</div>
	</div>
</div>
[/modal]

[modalMessageOk]
<div id="myModal" class="modal bgBlue">
	<div>
		<div class="blockTitle2 white text-center">
			<p class="title">{modalTitle}</p>
		</div>

		<div class="modalСontent text-center">
			{modalBody}

			<div class="ico like">
				<svg width="84" height="94" viewBox="0 0 84 94" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M51.4734 0.348828C50.3168 1.11992 50.2617 1.35859 50.2617 5.59961C50.2617 9.06953 50.2984 9.51016 50.6105 9.9875C51.1797 10.832 51.8773 11.1992 53.0156 11.1992C54.1539 11.1992 54.8516 10.832 55.4207 9.9875C55.7328 9.51016 55.7695 9.06953 55.7695 5.59961C55.7695 2.12969 55.7328 1.68906 55.4207 1.21172C54.8516 0.367188 54.1539 0 53.0156 0C52.3363 0 51.8406 0.110157 51.4734 0.348828Z" fill="white"/>
					<path d="M34.1603 7.72913C33.6095 8.00452 33.279 8.33499 33.022 8.88577C32.1958 10.5748 32.6365 11.5295 35.5556 14.3752C36.7673 15.5502 37.9607 16.5967 38.2361 16.7069C40.6595 17.6248 42.9177 15.3666 41.9997 12.9432C41.8896 12.6678 40.8431 11.4744 39.6681 10.2627C36.804 7.34358 35.831 6.90296 34.1603 7.72913Z" fill="white"/>
					<path d="M69.2455 7.71077C68.3642 8.15139 64.3068 12.2088 64.0314 12.9432C63.1135 15.3666 65.3717 17.6248 67.7951 16.7069C68.0705 16.5967 69.2638 15.5502 70.4756 14.3752C73.3947 11.5295 73.8353 10.5748 73.0092 8.88577C72.7338 8.31663 72.4217 8.00452 71.8525 7.72913C70.8795 7.25178 70.2002 7.25178 69.2455 7.71077Z" fill="white"/>
					<path d="M45.6902 17.3862C44.9375 18.0839 44.9375 18.0839 43.8359 22.3433C43.2301 24.6933 42.4773 27.2819 42.1469 28.1265C39.3195 35.3233 33.977 41.6206 29.0934 43.5116L27.7898 44.0257L27.1656 42.9792C26.3762 41.6573 26.1559 41.4187 24.8707 40.464C22.7961 38.9218 22.741 38.9218 11.909 38.9218C2.93125 38.9218 2.39883 38.9401 1.90312 39.2706C1.62773 39.4542 1.22383 39.8581 1.04023 40.1335C0.709766 40.6476 0.691406 41.4921 0.691406 66.4425C0.691406 91.7968 0.691406 92.219 1.05859 92.8065C1.82969 94.055 1.51758 94.0366 12.4414 93.9632L22.2637 93.9081L23.457 93.3206C24.9441 92.5862 25.9539 91.7417 26.8352 90.4565L27.5328 89.4651L32.9672 91.2644C41.5961 94.1101 39.5766 93.8714 56.5773 93.9448C70.5855 94.0183 71.0996 93.9999 72.1277 93.6511C74.7164 92.7882 76.6625 90.787 77.5254 88.1616C77.7641 87.4089 77.8191 86.7847 77.7457 85.4077C77.6906 84.4347 77.5988 83.4249 77.5254 83.1679C77.4152 82.7456 77.4887 82.6722 78.2965 82.3968C79.4898 81.9745 81.1238 80.6343 81.9316 79.4593C83.7676 76.7421 83.7676 72.446 81.95 70.0593C81.3625 69.2698 81.3625 69.1597 81.95 68.3702C83.7676 66.0019 83.7676 61.412 81.95 59.0437C81.693 58.6948 81.4727 58.3093 81.4727 58.1991C81.4727 58.089 81.693 57.7034 81.95 57.3546C83.2535 55.6472 83.7125 52.2874 82.9598 50.0659C82.0969 47.5507 80.1875 45.6413 77.6539 44.7784C76.7176 44.4479 76.0383 44.4296 67.8867 44.4296H59.1109L59.5516 42.9425C60.0656 41.1616 60.6531 38.0589 61.0203 35.1214C61.3875 32.1472 61.3691 26.3823 60.9836 24.9136C59.9922 21.0948 56.8895 17.9921 53.0707 17.0007C52.2996 16.7987 51.1062 16.7069 49.1969 16.7069H46.4613L45.6902 17.3862ZM52.5934 22.9675C53.8785 23.5917 54.5211 24.2526 55.2004 25.703C55.6594 26.6761 55.6777 26.8413 55.6594 29.6503C55.641 31.5046 55.4758 33.5976 55.2371 35.3417C54.8516 38.1507 53.8418 42.5019 53.3094 43.7319L53.0156 44.4296H49.7477C46.1676 44.4296 45.8555 44.5214 45.1027 45.6413C44.6437 46.3573 44.6254 48.0097 45.1027 48.7073C45.8922 49.919 44.809 49.8272 61.0019 49.9374C75.2855 50.0292 75.7078 50.0476 76.2953 50.3964C78.0578 51.4612 78.0762 53.8663 76.332 54.9495C75.7445 55.3167 75.3773 55.3534 72.0176 55.4452C68.0336 55.537 67.8316 55.5921 67.134 56.6753C66.675 57.3729 66.675 59.0253 67.134 59.7229C67.8316 60.8062 68.0336 60.8612 72.0176 60.953C76.0934 61.0632 76.534 61.1733 77.2684 62.3483C78.0027 63.5601 77.5621 65.2491 76.2953 66.0019C75.7629 66.3323 75.2488 66.369 72.0176 66.4608C68.0336 66.5526 67.8316 66.6077 67.134 67.6909C66.675 68.3886 66.675 70.0409 67.134 70.7386C67.8316 71.8218 68.0336 71.8769 72.0176 71.9687C75.3773 72.0604 75.7445 72.0972 76.332 72.4644C77.1766 72.9784 77.6172 73.7679 77.6172 74.7226C77.6172 75.6772 77.1766 76.4667 76.332 76.9808C75.7445 77.3479 75.3773 77.3847 72.0176 77.4765C68.9699 77.5499 68.2723 77.6233 67.9051 77.8804C67.134 78.4312 66.7852 79.1472 66.7852 80.1937C66.7852 81.9011 67.6664 82.8374 69.4656 83.0761C71.118 83.2964 72.1094 84.2878 72.1094 85.7015C72.1094 86.6929 71.6687 87.464 70.8242 87.9964L70.1816 88.4003H57.2383C45.8371 88.4003 44.093 88.3636 42.5508 88.0882C41.5961 87.9046 37.9793 86.8397 34.5277 85.7015L28.2305 83.6452V66.7179V49.8089L29.4055 49.4968C35.5559 47.8261 41.6695 42.0245 45.7453 34.0015C47.2508 31.0272 48.0586 28.7874 49.0133 25.1522L49.766 22.2331L50.6105 22.3249C51.0695 22.38 51.9691 22.6737 52.5934 22.9675ZM21.2172 44.8886C21.5477 45.0905 22.0066 45.5495 22.227 45.8983L22.6309 46.5409V66.4608V86.3808L22.227 87.0233C22.0066 87.3722 21.5477 87.8312 21.2172 88.0331C20.648 88.3819 20.2258 88.4003 13.4145 88.4554L6.19922 88.5105V66.4608V44.4112L13.4145 44.4663C20.2258 44.5214 20.648 44.5397 21.2172 44.8886Z" fill="white"/>
					<path d="M12.9187 77.8254C12.0742 78.3945 11.707 79.0922 11.707 80.2305C11.707 81.9746 12.7168 82.9844 14.4609 82.9844C16.2051 82.9844 17.2148 81.9746 17.2148 80.2305C17.2148 78.4863 16.2051 77.4766 14.4609 77.4766C13.7816 77.4766 13.2859 77.5867 12.9187 77.8254Z" fill="white"/>
				</svg>
			</div>
		</div>
	</div>
</div>
[/modalMessageOk]