import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { Vendor, Campaign, Company, Detail } from '../models/vendor.model';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class CampaignService {
  public apiUrlValue = environment.apiUrl;
  private readonly themeId = '4';
  private readonly themeType = 'restaurant-theme';

  constructor(private http: HttpClient) {}

  private normalizeGoogleMap(google_map: any): string[] {
    if (!google_map) {
      console.warn('google_map is null or undefined:', google_map); 
      return [];
    }
    if (Array.isArray(google_map)) {
      return google_map;
    } else if (typeof google_map === 'string') {
      return [google_map];
    }
    console.warn('نوع غير متوقع لـ google_map:', google_map); 
    return [];
  }

  getVendors(): Observable<Vendor[]> {
    return this.http.get(`${this.apiUrlValue}/api/product`).pipe(
      map((response: any) => {
        if (!response || !Array.isArray(response.data)) return [];
        const vendors: Vendor[] = [];
        response.data
          .filter((ad: any) => ad.company_theme?.toString() === this.themeId)
          .forEach((ad: any) => {
            if (ad.products && Array.isArray(ad.products)) {
              ad.products.forEach((product: any) => {
                let images: string[] = [];
                if (Array.isArray(product.image)) {
                  images = product.image;
                } else if (typeof product.image === 'string') {
                  images = product.image.split(',').map((img: string) => img.trim());
                }

                const imageUrls = images.map((img: string) => {
                  if (img.startsWith('http://') || img.startsWith('https://')) {
                    return img;
                  }
                  return `${this.apiUrlValue}/${img}`;
                });

                vendors.push({
                  id: product.id.toString(),
                  type: this.themeType,
                  name: product.name,
                  description: product.description,
                  branch: '',
                  link: product.link || `/product/${product.id}`,
                  phone: product.phone,
                  instagramLink: product.instagram,
                  facebook: product.facebook,
                  snapchat: product.snapchat,
                  whatsapp: product.whatsapp,
                  locationLink: product.link,
                  image: images,
                  imageUrls,
                  campaigns: [],
                  details: product.product_details
                    ? product.product_details.map((detail: any) => ({
                        id: detail.id,
                        product_id: detail.product_id.toString(),
                        ads_id: detail.ads_id.toString(),
                        date: detail.date,
                        type: detail.type,
                        count: detail.count,
                        created_at: detail.created_at,
                        updated_at: detail.updated_at,
                      }))
                    : [],
                });
              });
            }
          });
        console.log('الفيندورز المعالجين:', vendors);
        return vendors;
      }),
      catchError((err) => {
        console.error('خطأ في جلب المنتجات:', err);
        return of([]);
      })
    );
  }

 
  getAdDetails(slug: string): Observable<Campaign | null> {
    return this.http.get(`${this.apiUrlValue}/api/ads/${slug}`).pipe(
      map((response: any) => {
        const ad = response.data;
        if (!ad || ad.company_theme?.toString() !== this.themeId) return null;

        const products = ad.products.map((product: any) => {
          let images: string[] = [];
          if (Array.isArray(product.image)) {
            images = product.image;
          } else if (typeof product.image === 'string') {
            images = product.image.split(',').map((img: string) => img.trim());
          }

          const imageUrls = images.map((img: string) => {
            if (img.startsWith('http://') || img.startsWith('https://')) {
              return img;
            }
            return `${this.apiUrlValue}/${img}`;
          });

          return {
            id: product.id.toString(),
            name: product.name,
            category_name: product.catgory_name,
            company_name: product.company_name,
            description: product.description,
            location: product.location,
            image: images,
            imageUrls,
            whatsapp: product.whatsapp,
            facebook: product.facebook,
            instagram: product.instagram,
            snapchat: product.snapchat,
            phone: product.phone,
            details: product.product_details
              ? product.product_details.map((detail: any) => ({
                  id: detail.id,
                  product_id: detail.product_id.toString(),
                  ads_id: detail.ads_id.toString(),
                  date: detail.date,
                  type: detail.type,
                  count: detail.count,
                  created_at: detail.created_at,
                  updated_at: detail.updated_at,
                }))
              : [],
          };
        });

        const branches = ad.branches ? ad.branches.map((branch: any) => ({
          id: branch.id.toString(),
          name: branch.name,
          description: branch.description, 
          slug:branch.slug,
          whatsapp: branch.whatsapp,
          facebook: branch.facebook,
          instagram: branch.instagram,
          snapchat: branch.snapchat,
          phone: branch.phone,
          google_Map: this.normalizeGoogleMap(branch.google_Map),
              menu: branch.menu
              ? (branch.menu.startsWith('http') ? branch.menu : `${this.apiUrlValue}/${branch.menu}`)
              : null,
          products: branch.products || [],
        })) : [];

        let cats = ad.cats || [];
        if (typeof cats === 'string') {
          try {
            cats = JSON.parse(cats);
          } catch (e) {
            console.error('خطأ في تحويل cats إلى array:', e);
            cats = [];
          }
        }
        console.log('الـ cats بعد التحويل:', cats);

        return {
          id: ad.id.toString(),
          name: ad.name,
          company_id: ad.company_id.toString(),
          start_date: ad.start_date,
          end_date: ad.end_date,
          amount_per_day: parseFloat(ad.amount_per_day),
          product_ids: JSON.parse(ad.product_ids || '[]'),
          products,
          company_theme: this.themeId,
          type: this.themeType,
          url: ad.url || '',
          has_branch: ad.has_branch,
          has_product: ad.has_product,
          branches,
          cats,
        } as Campaign;
      }),
      catchError((err) => {
        console.error(`خطأ في جلب تفاصيل الإعلان ${slug}:`, err);
        return of(null); 
      })
    );
  }

  getCompany(id: string | number): Observable<Company | null> {
    console.log('المعرف اللي رايح للـ getCompany:', id);
    return this.http.get<{ code: number; message: string; data: Company }>(`${this.apiUrlValue}/api/company/${id}`).pipe(
      map((response) => {
        console.log('استجابة API getCompany:', response);
        if (response.code === 200 && response.data) {
          const company = {
            ...response.data,
            id: Number(response.data.id),
            logo: response.data.logo
              ? (response.data.logo.startsWith('http') ? response.data.logo : `${this.apiUrlValue}/${response.data.logo}`)
              : null,
          } as Company;
          return company;
        }
        console.warn(`لم يتم العثور على شركة بمعرف ${id}`);
        return null;
      }),
      catchError((err) => {
        console.error(`خطأ في جلب الشركة بمعرف ${id}:`, err);
        return of(null);
      })
    );
  }

  getAdByTheme(): Observable<Campaign | null> {
    return this.http.get(`${this.apiUrlValue}/api/ads`).pipe(
      map((response: any) => {
        const ads = response.data || [];
        const matchedAd = ads.find((ad: any) => ad.company_theme?.toString() === this.themeId);

        if (!matchedAd) {
          console.error(`مفيش إعلان بالثيم ${this.themeType}`);
          return null;
        }

        const products = matchedAd.products.map((product: any) => {
          let images: string[] = [];
          if (Array.isArray(product.image)) {
            images = product.image;
          } else if (typeof product.image === 'string') {
            images = product.image.split(',').map((img: string) => img.trim());
          }

          const imageUrls = images.map((img: string) => {
            if (img.startsWith('http://') || img.startsWith('https://')) {
              return img;
            }
            return `${this.apiUrlValue}/${img}`;
          });

          return {
            id: product.id.toString(),
            name: product.name,
            category_name: product.catgory_name,
            company_name: product.company_name,
            description: product.description,
            location: product.location,
            image: images,
            imageUrls,
            whatsapp: product.whatsapp,
            instagram: product.instagram,
            phone: product.phone,
          };
        });

        const branches = matchedAd.branches ? matchedAd.branches.map((branch: any) => ({
          id: branch.id.toString(),
          name: branch.name,
          slug:branch.slug,
          description: branch.description,
          whatsapp: branch.whatsapp,
          facebook: branch.facebook,
          instagram: branch.instagram,
          snapchat: branch.snapchat,
          phone: branch.phone,
          google_Map: this.normalizeGoogleMap(branch.google_Map),
                   menu: branch.menu
            ? (branch.menu.startsWith('http') ? branch.menu : `${this.apiUrlValue}/${branch.menu}`)
            : null,
          products: branch.products || [],
        })) : [];

        return {
          id: matchedAd.id.toString(),
          name: matchedAd.name,
          company_id: matchedAd.company_id.toString(),
          start_date: matchedAd.start_date,
          end_date: matchedAd.end_date,
          amount_per_day: parseFloat(matchedAd.amount_per_day),
          product_ids: JSON.parse(matchedAd.product_ids || '[]'),
          products,
          company_theme: this.themeId,
          type: this.themeType,
          has_branch: matchedAd.has_branch,
          has_product: matchedAd.has_product,
          branches,
        } as Campaign;
      }),
      catchError((err) => {
        console.error(`خطأ في جلب الحملات بالثيم ${this.themeType}:`, err);
        return of(null);
      })
    );
  }

 trackVisit(productId: string | null, adsId: string | null, isCategory: boolean = false, isProduct: boolean = false) {
    if (!adsId) {
        console.warn('معرف الإعلان (ads_id) غير موجود. لن يتم تسجيل الزيارة.');
        return;
    }

    const date = new Date().toISOString().split('T')[0];
    const payload: any = {
        type: 'visit',
        date: date,
        ads_id: adsId, // استخدام ads_id بدل الـ slug
    };

    if (isCategory && productId) {
        payload.cat_id = productId.toString();
    } else if (isProduct && productId) {
        payload.product_id = productId.toString();
    }

    console.log('طلب trackVisit:', payload);
    this.http.post(`${this.apiUrlValue}/api/details`, payload).subscribe({
        next: (response) => {
            console.log(
                `تم تسجيل زيارة${isCategory ? ` للفرع ${productId}` : isProduct ? ` للمنتج ${productId}` : ` للإعلان ${adsId}`}`,
                response
            );
        },
        error: (err) => {
            console.error('خطأ في تتبع زيارة:', err);
            console.log('تفاصيل الخطأ:', {
                status: err.status,
                statusText: err.statusText,
                error: err.error,
                message: err.message,
            });
        },
    });
}
 trackClick(type: string, entityId: string | null, adsId: string | null, isCategory: boolean, isProduct: boolean, isSecondMap: boolean = false) {
    if (!adsId || !entityId || !type) {
        console.warn('معرف الإعلان (ads_id)، الكيان (فرع/منتج)، أو نوع النقرة غير موجود.');
        return;
    }

    const date = new Date().toISOString().split('T')[0];
    const payload: any = {
        type: isSecondMap ? 'google_Map_2' : type,
        date: date,
        ads_id: adsId, // استخدام ads_id بدل الـ slug
    };

    if (isCategory) {
        payload.cat_id = entityId.toString();
    } else if (isProduct) {
        payload.product_id = entityId.toString();
    } else {
        throw new Error('يجب تحديد ما إذا كان الكيان فرعًا (isCategory) أو منتجًا (isProduct)');
    }

    console.log('طلب trackClick:', payload);
    this.http.post(`${this.apiUrlValue}/api/details`, payload).subscribe({
        next: (response) => {
            console.log(`تم تسجيل نقرة ${payload.type}${isCategory ? ` للفرع ${entityId}` : isProduct ? ` للمنتج ${entityId}` : ''}`, response);
        },
        error: (err) => {
            console.error('خطأ في تتبع النقرة:', err);
            console.log('تفاصيل الخطأ:', {
                status: err.status,
                statusText: err.statusText,
                error: err.error,
                message: err.message,
            });
        },
    });
}

  getProductById(id: string): Observable<Vendor | null> {
    console.log('جاري جلب المنتج بمعرف:', id);
    return this.http.get(`${this.apiUrlValue}/api/product/${id}`).pipe(
      map((response: any) => {
        const product = response.data || response;
        if (!product) {
          console.warn('لا توجد بيانات للمنتج في الاستجابة');
          return null;
        }

        let images: string[] = [];
        if (Array.isArray(product.image)) {
          images = product.image;
        } else if (typeof product.image === 'string') {
          images = product.image.split(',').map((img: string) => img.trim());
        } else if (Array.isArray(product.images)) {
          images = product.images;
        }

        const imageUrls = images.map((img: string) => {
          if (img.startsWith('http://') || img.startsWith('https://')) {
            return img;
          }
          return `${this.apiUrlValue}/${img}`;
        });

        return {
          id: product.id.toString(),
          type: this.themeType,
          name: product.name,
          description: product.description,
          branch: '',
          link: product.link || `/product/${product.id}`,
          phone: product.phone,
          instagramLink: product.instagram,
          facebook: product.facebook,
          snapchat: product.snapchat,
          whatsapp: product.whatsapp,
          locationLink: product.link,
          image: images,
          imageUrls,
          campaigns: [],
          details: product.product_details
            ? product.product_details.map((detail: any) => ({
                id: detail.id,
                product_id: detail.product_id.toString(),
                ads_id: detail.ads_id.toString(),
                date: detail.date,
                type: detail.type,
                count: detail.count,
                created_at: detail.created_at,
                updated_at: detail.updated_at,
              }))
            : [],
        } as Vendor;
      }),
      catchError((err) => {
        console.error('خطأ في جلب المنتج:', err);
        return of(null);
      })
    );
  }

  getBranch(adSlug: string, branchSlug: string): Observable<any | null> {
    return this.getAdDetails(adSlug).pipe(
      map((ad: Campaign | null) => {
        if (ad && ad.branches) {
          const branch = ad.branches.find((b: any) => b.id.toString() === branchSlug);
          if (branch) {
             return {
              id: branch.id,
              name: branch.name,
              description: branch.description,
              whatsapp: branch.whatsapp,
              facebook: branch.facebook,
              instagram: branch.instagram,
              snapchat: branch.snapchat,
              phone: branch.phone,
              google_Map: this.normalizeGoogleMap(branch.google_Map), 
              menu: branch.menu ? (branch.menu.startsWith('http') ? branch.menu : `${this.apiUrlValue}/${branch.menu}`) : null,
            };
          }
          console.warn(`لم يتم العثور على فرع بمعرف ${branchSlug}`);
          return null;
        }
        console.warn(`لا توجد فروع في الإعلان ${adSlug}`);
        return null;
      }),
      catchError((err) => {
        console.error(`خطأ في جلب تفاصيل الفرع ${branchSlug}:`, err);
        return of(null);
      })
    );
  }
}