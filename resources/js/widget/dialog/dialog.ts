import { ElMessageBox, ElMessage } from 'element-plus'

export function alert(title: string, message: string): Promise<unknown> {
 return new Promise((resolve, reject) => {
     ElMessageBox({
         title: title,
         message: message,
         showCancelButton: true,
         confirmButtonText: 'OK',
         cancelButtonText: 'Отменить'
     }).then((action) => {
         if (action === 'confirm') {
             resolve()
         } else {
             reject()
         }
     }).catch(() => {
         reject()
     })
 })
}

export function message(message: string, type: "success" | "warning" | "error" | "info" = "info") {
    ElMessage({
        type: type,
        message: message,
    })
}
