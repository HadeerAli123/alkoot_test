// import { Component, OnInit } from '@angular/core';
// import { MatDialog } from '@angular/material/dialog';
// import { Router, ActivatedRoute } from '@angular/router';
// import { CampaignService } from '../../../services/campaign';
// import { Vendor, Campaign, Company } from '../../../models/vendor.model';
// import { CommonModule } from '@angular/common';
// import { ConfirmationDialog } from '../confirmation-dialog/confirmation-dialog';

// @Component({
//   selector: 'app-campaign-list',
//   standalone: true,
//   imports: [CommonModule, ConfirmationDialog],
//   templateUrl: './campaign-list.html',
//   styleUrls: ['./campaign-list.css']
// })
// export class CampaignList implements OnInit {
//   vendors: Vendor[] = [];
//   filteredVendors: Vendor[] = [];
//   currentAdId: string | null = null;
//   adDetails: Campaign | null = null;
//   company: Company | null = null;
//   errorMessage: string | null = null;
//   socialTypes: string[] = ['phone', 'whatsapp', 'instagram'];
//   displayUrl: string | null = null;

//   constructor(
//     public campaignService: CampaignService,
//     public dialog: MatDialog,
//     private router: Router,
//     private route: ActivatedRoute
//   ) {}

//   ngOnInit(): void {
//     this.route.paramMap.subscribe(params => {
//       this.currentAdId = params.get('adId');
//       console.log('معرف الإعلان:', this.currentAdId);

//       if (!this.currentAdId) {
//         console.warn('الرابط غير صحيح. لا يوجد معرف الإعلان.');
//         this.errorMessage = 'الرابط غير صحيح. تأكد من وجود معرف الإعلان.';
//         this.router.navigate(['']);
//         return;
//       }

//       this.campaignService.getAdDetails(this.currentAdId).subscribe({
//         next: (ad) => {
//           if (!ad) {
//             console.warn('الإعلان غير موجود أو غير متطابق مع الثيم restaurant-theme');
//             this.errorMessage = 'الإعلان غير متوفر أو غير متطابق مع الثيم.';
//             this.router.navigate(['']);
//             return;
//           }
            
//         let cats = ad.cats || [];
        
//      if (cats.includes('all')) {
//             console.log('تم العثور على "all" في cats');
//             if (ad.branches && ad.branches.length === 1) {
//               const branchId = ad.branches[0].id.toString();
//               console.log('فرع واحد فقط، توجيه مباشر إلى الفرع:', branchId);
//               this.router.navigate([`/${this.currentAdId}/${branchId}`]);
//               return;
//             } else {
//               console.log('أكتر من فرع أو لا يوجد فروع، توجيه إلى صفحة الفروع');
//               this.router.navigate([`/branches/${this.currentAdId}`]);
//               return;
//             }
//           }

//           // if (cats.length === 1 && cats[0] === 'all') {
//           //   console.log('cats تحتوي على "all" فقط، توجيه إلى صفحة الفروع');
//           //   this.router.navigate([`/branches/${this.currentAdId}`]);
//           //   return;
//           // }

//           if (cats.length > 1) {
//             console.log('توجيه إلى صفحة الفروع لأن في أكتر من cat');
//             this.router.navigate([`/branches/${this.currentAdId}`]);
//             return;
//           }

//           if (cats.length === 1) {
//             console.log('توجيه مباشر لصفحة الفرع:', cats[0]);
//             this.router.navigate([`/${this.currentAdId}/${cats[0]}`]);
//             return;
//           } else {
//             console.warn('لا توجد فروع في cats:', cats);
//             this.errorMessage = 'لا توجد فروع متاحة لهذا الإعلان.';
//             this.router.navigate(['']);
//             return;
//           }
//         },
//         error: (err) => {
//           console.error('خطأ في جلب تفاصيل الإعلان:', err);
//           this.errorMessage = 'تعذر تحميل تفاصيل الإعلان. حاول مرة أخرى لاحقًا.';
//           this.router.navigate(['']);
//         }
//       });
//     })}}
// /////هكمل الفانكشن هنا والبرانش ليست 

// //           if (ad.branches && ad.branches.length>1){
// //          this.router.navigate([`/branches/${this.currentAdId}`]);
         
// //           return;
// //           }
// //          else if(ad.branches && ad.branches.length===1 ){
// //     this.router.navigate([`/${this.currentAdId}/${ad.branches[0].id}`]);
// // return;
// //          }
       
        

//   // private handleAdResponse(ad: Campaign | null) {
//   //   this.adDetails = ad;
//   //   console.log('تفاصيل الإعلان:', ad);

//   //   if (ad?.products && Array.isArray(ad.products)) {
//   //     this.vendors = ad.products.map((product: any) => {
//   //       let images: string[] = [];
//   //       if (typeof product.image === 'string') {
//   //         try {
//   //           images = product.image.split(',').map((img: string) => img.trim());
//   //         } catch (e) {
//   //           console.error('خطأ في تحويل الصور للمنتج:', product.id, product.image);
//   //           images = [];
//   //         }
//   //       } else if (Array.isArray(product.image)) {
//   //         images = product.image;
//   //       }

//   //       const imageUrls = images.map((img: string) => {
//   //         if (img.startsWith('http://') || img.startsWith('https://')) {
//   //           return img;
//   //         }
//   //         return `${this.campaignService.apiUrlValue}/${img}`;
//   //       });

//   //       console.log('عرض أول صورة:', imageUrls[0]);

//   //       return {
//   //         id: product.id.toString(),
//   //         type: 'restaurant-theme',
//   //         name: product.name,
//   //         description: product.description,
//   //         branch: '',
//   //         link: product.link || `/product/${product.id}`,
//   //         phone: product.phone,
//   //         instagramLink: product.instagram,
//   //         facebook: product.facebook,
//   //         snapchat: product.snapchat,
//   //         whatsapp: product.whatsapp,
//   //         locationLink: product.link,
//   //         image: images,
//   //         imageUrls,
//   //         campaigns: [],
//   //         details: product.product_details ? product.product_details.map((detail: any) => ({
//   //           id: detail.id,
//   //           product_id: detail.product_id.toString(),
//   //           ads_id: detail.ads_id.toString(),
//   //           date: detail.date,
//   //           type: detail.type,
//   //           count: detail.count,
//   //           created_at: detail.created_at,
//   //           updated_at: detail.updated_at
//   //         })) : []
//   //       };
//   //     });

//   //     this.filteredVendors = this.vendors;
//   //     console.log('الفيندورز:', this.vendors);
//   //   } else {
//   //     this.vendors = [];
//   //     this.filteredVendors = [];
//   //     this.errorMessage = 'لا توجد منتجات متاحة لهذا الإعلان.';
//   //   }

//   //   if (ad?.company_id) {
//   //     this.campaignService.getCompany(ad.company_id).subscribe({
//   //       next: (company) => {
//   //         this.company = company || null;
//   //         console.log('بيانات الشركة:', company);
//   //       },
//   //       error: (err) => {
//   //         console.error('خطأ في جلب الشركة:', err);
//   //         this.company = null;
//   //       }
//   //     });
//   //   } else {
//   //     this.company = null;
//   //   }
//   // }

// //   getVendorImage(vendor: Vendor): string {
// //     if (vendor.imageUrls && vendor.imageUrls.length > 0) {
// //       console.log('عرض أول صورة:', vendor.imageUrls[0]);
// //       return vendor.imageUrls[0];
// //     }
// //     return 'assets/default.jpg';
// //   }

// //   getBannerTitle(): string {
// // return 'استمتع بأشهى المأكولات';
// //  }

// //   getBannerSubtitle(): string {
// //  return 'عروض مميزة لجميع الأذواق';
// //   }

// //   getRoomsTitle(): string {
// //     return this.adDetails?.name || '';
// //   }

// //   getMainTitle(): string {
// //   return 'مطاعم في الكويت بأشهى الأطباق';

// //   }

// //   getFooterTitle(): string {
// // return 'مطاعم ومقاهي الفخامة';
// //   }

// //   getFooterImage(): string {
// //  return 'assets/footer-image (2).png';
// //   }

// //   getBannerImage(): string {
// //    return 'assets/DSCF1069.jpg';
// //   }

//   // getSocialLink(type: string, vendor: Vendor): string | undefined {
//   //   switch (type) {
//   //     case 'phone': return vendor.phone;
//   //     case 'whatsapp': return vendor.whatsapp;
//   //     case 'instagram': return vendor.instagramLink;
//   //     default: return undefined;
//   //   }
//   // }

//   // handleSocialClick(vendor: Vendor, type: string) {
//   //   const productId = vendor.id;
//   //   const link = this.getSocialLink(type, vendor);

//   //   if (!link) {
//   //     console.error(`مفيش رابط للنوع ${type} في الفيندور ${vendor.id}`);
//   //     return;
//   //   }

//   //   if (!this.currentAdId) {
//   //     console.warn('معرف الإعلان غير موجود.');
//   //     return;
//   //   }

//   //   this.campaignService.trackClick(type, productId, this.currentAdId, false, true);
//   //   console.log(`تم تسجيل نقرة على ${type} للمنتج ${productId} مع الإعلان ${this.currentAdId}`);

//   //   if (type === 'phone' || type === 'whatsapp') {
//   //     const dialogRef = this.dialog.open(ConfirmationDialog, {
//   //       width: '250px',
//   //       data: { message: `Open ${type === 'phone' ? 'Call' : 'WhatsApp'}?`, action: type, phone: link },
//   //       id: `${type}-confirmation-dialog`
//   //     });

//   //     dialogRef.afterClosed().subscribe(result => {
//   //       if (result === 'open') {
//   //         if (type === 'phone') {
//   //           window.location.href = `tel:${link}`;
//   //         } else if (type === 'whatsapp') {
//   //           window.open(`https://api.whatsapp.com/send?phone=${link}`, '_blank');
//   //         }
//   //       }
//   //     });
//   //   } else {
//   //     window.open(link, '_blank');
//   //   }
//   // }

//   // goToDetails(productId: string) {
//   //   const vendor = this.vendors.find(v => v.id === productId);
//   //   if (vendor) {
//   //     if (!this.currentAdId) {
//   //       console.warn('معرف الإعلان غير موجود.');
//   //       return;
//   //     }

//   //     this.campaignService.trackVisit(productId, this.currentAdId, false, true);
//   //     console.log(`تم تسجيل زيارة للمنتج ${productId} عند النقر على زر التفاصيل`);
//   //     this.router.navigate(['/product', productId], {
//   //       queryParams: { type: 'restaurant-theme' },
//   //       state: {
//   //         socialDetails: vendor.details || [],
//   //         product: vendor,
//   //         adId: this.currentAdId,
//   //         visitTracked: true
//   //       }
//   //     });
//   //   } else {
//   //     console.warn(`الفيندور بالمعرف ${productId} غير موجود`);
//   //   }
//   // }

// //  goToBranches(): void {
// //   if (this.currentAdId && this.adDetails?.branches) {
// //     const branchCount = this.adDetails.branches.length;

// //     if (branchCount === 1) {
// //       const branchId = this.adDetails.branches[0].id;
// //  this.router.navigate([`/branch/${this.currentAdId}/${branchId}`]);
// //     } else if (branchCount > 1) {
// //       this.router.navigate([`/branches/${this.currentAdId}`]);
// //     }
// //   }
// // }


//   // getIconClass(type: string): string {
//   //   switch (type) {
//   //     case 'whatsapp': return 'fab fa-whatsapp';
//   //     case 'phone': return 'fas fa-phone';
//   //     case 'instagram': return 'fab fa-instagram';
//   //     default: return 'fas fa-share-alt';
//   //   }
//   // }

  
