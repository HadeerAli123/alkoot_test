import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { CampaignService } from './../../../services/campaign';
import { CommonModule } from '@angular/common';
import { MatDialog } from '@angular/material/dialog';
import { ConfirmationDialog } from '../confirmation-dialog/confirmation-dialog';

@Component({
  selector: 'app-branches-list',
  standalone: true,
  imports: [CommonModule, ConfirmationDialog],
  templateUrl: './branch-list.html',
  styleUrls: ['./branch-list.css']
})
export class BranchesList implements OnInit {
  branches: any[] = [];
  currentAdId: string | null = null;
  errorMessage: string | null = null;
  company: any = null;
  displayUrl: string | null = null;
    branchSlug: string | null = null;
      currentAdSlug: string | null = null;

  constructor(
    private campaignService: CampaignService,
    private router: Router,
    private route: ActivatedRoute,
    public dialog: MatDialog
  ) {}

ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      this.currentAdSlug = params.get('slug'); 
      console.log('معرف الإعلان (slug):', this.currentAdSlug);

      if (!this.currentAdSlug) {
        this.errorMessage = 'الرابط غير صحيح. تأكد من وجود slug للإعلان.';
        this.router.navigate(['']);
        return;
      }

      this.campaignService.getAdDetails(this.currentAdSlug).subscribe({
        next: (ad) => {
          if (!ad) {
            this.errorMessage = 'الإعلان غير موجود أو حدث خطأ أثناء التحميل.';
            this.router.navigate(['']);
            return;
          }

          this.displayUrl = ad.url || null;
          console.log('الـ URL للعرض:', this.displayUrl);

          this.currentAdId = ad.id;

          if (!ad.has_branch) {
            this.errorMessage = 'هذا الإعلان لا يحتوي على فروع.';
            this.router.navigate(['']);
            return;
          }

          // جلب بيانات الشركة
          if (ad.company_id) {
            this.campaignService.getCompany(ad.company_id).subscribe({
              next: (company) => {
                this.company = company;
                console.log('بيانات الشركة:', company);
              },
              error: (err) => {
                console.error('خطأ في جلب الشركة:', err);
                this.company = null;
              }
            });
          }


          let cats = ad.cats || [];
          console.log('الـ cats بعد التحويل:', cats);

          // جلب الفروع (عرضها)
          this.branches = cats.includes('all')
            ? (ad.branches || [])
            : (ad.branches || []).filter((b: any) =>
                cats.map((cat: any) => cat.toString()).includes(b.id.toString())
              );
          console.log('الفروع بعد الفلترة:', this.branches);


/////تعديل الزيارات للافرع 
         
if (cats.includes('all') && ad.branches && ad.branches.length === 1) {
  const branchSlug = ad.branches[0].slug || ad.branches[0].id.toString();
  console.log('فرع واحد فقط، توجيه مباشر إلى الفرع:', branchSlug);
  this.router.navigate([`${this.currentAdSlug}/${branchSlug}`]);
  return; 
}


if (cats.includes('all') || cats.length > 1) {
  this.campaignService.trackVisit(null, this.currentAdId, false);
  console.log(`تم تسجيل زيارة عامة للإعلان ${this.currentAdId}`);
}
          if (this.branches.length === 0) {
            console.warn('لا توجد فروع متاحة بعد الفلترة. Cats:', cats, 'Branches:', ad.branches);
            this.errorMessage = 'لا توجد فروع متاحة لهذا الإعلان.';
            this.router.navigate(['']);
            return;
          }
////////////////////////////////
          if (cats.includes('all')) {
            console.log('تم العثور على "all" في cats');
            if (ad.branches && ad.branches.length === 1) {
              const branchSlug = ad.branches[0].slug || ad.branches[0].id.toString();
              console.log('فرع واحد فقط، توجيه مباشر إلى الفرع:', branchSlug);
              this.router.navigate([`${this.currentAdSlug}/${branchSlug}`]);
              return;
            } else {
              console.log('أكتر من فرع أو لا يوجد فروع، توجيه إلى صفحة الفروع');
              this.router.navigate([`${this.currentAdSlug}`]);
              return;
            }
          }

          if (cats.length > 1) {
            console.log('توجيه إلى صفحة الفروع لأن في أكتر من cat');
            this.router.navigate([`${this.currentAdSlug}`]);
            return;
          }

              if (cats.length === 1) {
            const branch = this.branches.find(b => b.id.toString() === cats[0].toString());
            const branchSlug = branch ? (branch.slug || branch.id.toString()) : cats[0];
            console.log('توجيه مباشر لصفحة الفرع:', branchSlug);
            this.router.navigate([`${this.currentAdSlug}/${branchSlug}`]);
            return;
          }
        

          console.warn('لا توجد فروع في cats:', cats);
          this.errorMessage = 'لا توجد فروع متاحة لهذا الإعلان.';
          this.router.navigate(['']);
          return;
        },
        error: (err) => {
          console.error('خطأ في جلب تفاصيل الإعلان:', err);
          this.errorMessage = 'تعذر تحميل تفاصيل الإعلان. حاول مرة أخرى لاحقًا.';
          this.router.navigate(['']);
        }
      });
    });
  }

   goToBranchDetails(branchSlug: any) {
    this.router.navigate([`${this.currentAdSlug}/${branchSlug}`]);
  }
  handleSocialClick(branch: any, type: string) {
    const link = this.getSocialLink(type, branch);
    if (!link) {
      console.error(`مفيش رابط للنوع ${type} في الفرع ${branch.id}`);
      return;
    }

    if (!this.currentAdId) {
      console.warn('معرف الإعلان غير موجود.');
      return;
    }

    this.campaignService.trackClick(type, branch.id.toString(), this.currentAdId, true, false);
    console.log(`تم تسجيل نقرة على ${type} للفرع ${branch.id} مع الإعلان ${this.currentAdId}`);

    if (type === 'phone' || type === 'whatsapp') {
      const dialogRef = this.dialog.open(ConfirmationDialog, {
        width: '250px',
        data: { message: `Open ${type === 'phone' ? 'Call' : 'WhatsApp'}?`, action: type, phone: link },
        id: `${type}-confirmation-dialog`
      });

      dialogRef.afterClosed().subscribe(result => {
        if (result === 'open') {
          if (type === 'phone') {
            window.location.href = `tel:${link}`;
          } else if (type === 'whatsapp') {
            window.open(`https://api.whatsapp.com/send?phone=${link}`, '_blank');
          }
        }
      });
    } else {
      window.open(link, '_blank');
    }
  }

  getSocialLink(type: string, branch: any): string | undefined {
    switch (type) {
      case 'phone': return branch.phone;
      case 'whatsapp': return branch.whatsapp;
      case 'instagram': return branch.instagram;
      default: return undefined;
    }
  }
}