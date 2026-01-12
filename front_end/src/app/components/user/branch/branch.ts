
import { Component, OnInit } from '@angular/core';
import { CampaignService } from './../../../services/campaign';
import { ActivatedRoute } from '@angular/router';
import { SafeUrlPipe } from '../../../../app/safe-url.pipe';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-branch',
  standalone: true,
  imports: [CommonModule, SafeUrlPipe],
  templateUrl: './branch.html',
  styleUrls: ['./branch.css'],
  providers: [CampaignService]
})
export class BranchComponent implements OnInit {
  branch: any = null;
  branchId: string | null = null;
  adId: string | null = null;
  branchSlug: string | null = null; 
  currentAdSlug: string | null = null;
    private specialBranches = ['gorgya', 'athrbygan'];

  constructor(
    private campaignService: CampaignService,
    private route: ActivatedRoute
  ) {}

ngOnInit(): void {
  this.currentAdSlug = this.route.snapshot.paramMap.get('slug');
  this.branchSlug = this.route.snapshot.paramMap.get('branchSlug');
  if (this.currentAdSlug && this.branchSlug) {
    this.loadBranch(this.currentAdSlug, this.branchSlug);
  } else {
    console.warn('معرف الإعلان أو slug الفرع غير موجود في الـ URL');
  }
}

loadBranch(currentAdSlug: string, branchSlug: string): void {
  this.campaignService.getAdDetails(currentAdSlug).subscribe({
    next: (data) => {
      if (data && data.branches) {
        this.adId = data.id; 
        this.branch = data.branches.find((b: any) => b.slug === branchSlug);
        if (this.branch) {
          this.branchId = this.branch.id;
          console.log('بيانات الفرع:', this.branch);
          this.campaignService.trackVisit(this.branchId, this.adId, true);
        } else {
          console.warn('لم يتم العثور على الفرع المطلوب');
          this.branch = {};
        }
      } else {
        console.warn('لم يتم العثور على بيانات الإعلان أو الفروع');
        this.branch = {};
      }
    },
    error: (err) => {
      console.error('خطأ في جلب بيانات الفرع:', err);
      this.branch = {};
    }
  });
}

trackClick(type: string, isSecondMap: boolean = false): void {
    if (this.adId && this.branchId) {
      this.campaignService.trackClick(type, this.branchId, this.adId, true, false, isSecondMap); 
      console.log(`تم تسجيل نقرة على ${isSecondMap ? 'google_Map_2' : type} للفرع ${this.branchId} مع الإعلان ${this.adId}`);
    }
  }
    isSpecialBranch(): boolean {
    return this.branch && this.specialBranches.includes(this.branch.slug);
  }
}